var G5SHOP_SWATCHES = window.G5SHOP_SWATCHES || {};
(function ($) {
    "use strict";
    window.G5SHOP_SWATCHES = G5SHOP_SWATCHES;

    var $window = $(window),
        $body = $('body'),
        isRTL = $body.hasClass('rtl');

    G5SHOP_SWATCHES = {
        init: function () {
            this.initLoop();
            this.initSingle();
            this.updateAjaxSuccess();
            this.updateQuickViewSuccess();
        },
        initLoop: function () {
            var self = this;
            $('.g5shop__loop-swatches').each(function () {
                var $swatches = $(this),
                    $term = $swatches.find('.g5shop__swatches-item:not(.g5shop__sw-disabled)'),
                    $resetBtn = $swatches.find('.g5shop__reset_variations'),
                    $product = $swatches.closest(g5shop_vars.product_selector),
                    variationData = $swatches.data( 'product_variations' );

                $term.unbind( 'click' ).on( 'click', function( e ) {
                    var $this = $( this );
                    if ( $this.hasClass( 'g5shop__sw-disabled' ) ) {
                        return false;
                    }
                    var term = $this.data( 'term' );

                    $product.find('.g5shop__swatches-item').removeClass( 'g5shop__sw-disabled g5shop__sw-enabled' );
                    $this.parent().find( '.g5shop__swatches-item.g5shop__sw-selected' ).removeClass( 'g5shop__sw-selected' );


                    $this.addClass( 'g5shop__sw-selected' );

                    $product.addClass( 'g5shop__product-swatched' );
                    $resetBtn.show();

                    var attributes = self.getChosenAttributes($swatches ),
                        currentAttributes = attributes.data;

                    if ( attributes.count === attributes.chosenCount ) {
                        self.updateAttributes( $swatches, variationData );

                        var matching_variations = self.findMatchingVariations(variationData, currentAttributes ),
                            variation = matching_variations.shift();
                        if ( variation ) {
                            // Found variation
                            self.foundVariation( $swatches, variation );
                        } else {
                            $resetBtn.trigger( 'click' );
                        }
                    } else {
                        self.updateAttributes( $swatches, variationData );
                    }
                });

                $resetBtn.unbind( 'click' ).on( 'click', function () {

                    $product.removeClass( 'g5shop__product-swatched' );

                    $swatches.removeAttr( 'data-variation_id' );
                    $swatches.find( '.g5shop__swatches-item' ).removeClass('g5shop__sw-enabled g5shop__sw-disabled g5shop__sw-selected' );

                    $( 'body' ).trigger( 'isw_reset_add_to_cart_button_text' );

                    //$product.find( '.add_to_cart_button' ).removeClass(
                    //    'isw-ready isw-readmore isw-text-changed added loading' ).text( isw.localization.select_options_text );

                    // reset price
                    var $price = $product.find(g5shop_vars.price_selector).not( '.price-cloned' ),
                        $price_cloned = $product.find( '.price-cloned' );

                    if ( $price_cloned.length ) {
                        $price.html( $price_cloned.html() );
                        $price_cloned.remove();
                    }

                    // reset image
                    self.variationsImageUpdate( false, $product );

                    $( this ).hide();

                    return false;
                } );

            });
        },
        getChosenAttributes: function ($swatches) {
            var data = {},
                count = 0,
                chosen = 0,
                $swatch = $swatches.find( '.g5shop__swatch' );

            $swatch.each( function() {
                var attribute_name = 'attribute_' +
                    $( this ).attr( 'data-attribute' ),
                    value = $( this ).find( '.g5shop__swatches-item.g5shop__sw-selected' ).attr( 'data-term' ) || '';

                if ( value.length > 0 ) {
                    chosen ++;
                }

                count ++;
                data[attribute_name] = value;
            } );

            return {
                'count': count,
                'chosenCount': chosen,
                'data': data,
            };
        },
        updateAttributes: function ($swatches, variationData) {
            var self = this,
                attributes = self.getChosenAttributes( $swatches ),
                currentAttributes = attributes.data,
                available_options_count = 0,
                $swatch = $swatches.find( '.g5shop__swatch' );

            $swatch.each( function( idx, el ) {
                var current_attr_sw = $( el ),
                    current_attr_name = 'attribute_' + current_attr_sw.data('attribute' ),
                    selected_attr_val = current_attr_sw.find('.g5shop__swatches-item.g5shop__sw-selected' ).data('term' ),
                    selected_attr_val_valid = true,
                    checkAttributes = $.extend( true, {},currentAttributes );

                checkAttributes[current_attr_name] = '';

                var variations = self.findMatchingVariations(variationData, checkAttributes );

                for ( var num in variations ) {
                    if ( typeof variations[num] !== 'undefined' ) {
                        var variationAttributes = variations[num].attributes;
                        for ( var attr_name in variationAttributes ) {
                            if ( variationAttributes.hasOwnProperty(attr_name ) ) {
                                var attr_val = variationAttributes[attr_name],
                                    variation_active = '';

                                if ( attr_name === current_attr_name ) {
                                    if ( variations[num].variation_is_active ) {
                                        variation_active = 'g5shop__sw-enabled';
                                    }

                                    if ( attr_val ) {
                                        // available
                                        current_attr_sw.find('.g5shop__swatches-item[data-term="' + attr_val + '"]' ).addClass( variation_active );
                                    } else {
                                        // apply for all swatches
                                        current_attr_sw.find( '.g5shop__swatches-item' ).addClass(variation_active );
                                    }
                                }
                            }
                        }
                    }
                }

                available_options_count = current_attr_sw.find('.g5shop__swatches-item.g5shop__sw-enabled' ).length;

                if ( selected_attr_val && (
                    available_options_count === 0 || current_attr_sw.find('.g5shop__swatches-item.g5shop__sw-enabled[data-term="' + self.addSlashes( selected_attr_val ) + '"]' ).length === 0 ) ) {
                    selected_attr_val_valid = false;
                }

                // Disable terms not available
                current_attr_sw.find( '.g5shop__swatches-item:not(.g5shop__sw-enabled)' ).addClass( 'g5shop__sw-disabled' );


                // Choose selected value.
                if ( selected_attr_val ) {
                    // If the previously selected value is no longer available,
                    // fall back to the placeholder (it's going to be there).
                    if ( !selected_attr_val_valid ) {
                        current_attr_sw.find( '.g5shop__swatches-item.g5shop__sw-selected' ).removeClass( 'g5shop__sw-selected' );
                    }
                }
                else {
                    current_attr_sw.find( '.g5shop__swatches-item.g5shop__sw-selected' ).removeClass( 'g5shop__sw-selected' );
                }
            });
        },
        findMatchingVariations: function (variationData, settings) {
            var matching = [];
            for ( var i = 0; i < variationData.length; i ++ ) {
                var variation = variationData[i];

                if ( this.isMatch( variation.attributes, settings ) ) {
                    matching.push( variation );
                }
            }
            return matching;
        },
        isMatch: function( variation_attributes, attributes ) {
            var match = true;
            for ( var attr_name in variation_attributes ) {
                if ( variation_attributes.hasOwnProperty( attr_name ) ) {
                    var val1 = variation_attributes[attr_name];
                    var val2 = attributes[attr_name];
                    if ( val1 !== undefined && val2 !== undefined &&
                        val1.length !== 0 && val2.length !== 0 &&
                        val1 !== val2 ) {
                        match = false;
                    }
                }
            }
            return match;
        },
        addSlashes: function( string ) {
            string = string.replace( /'/g, '\\\'' );
            string = string.replace( /"/g, '\\\"' );
            return string;
        },
        foundVariation: function( $swatches, variation ) {
            var self = this,
                $product = $swatches.closest( g5shop_vars.product_selector ),
                $price = $product.find( g5shop_vars.price_selector ).not( '.price-cloned' ),
                $price_clone = $price.clone().addClass( 'price-cloned' ).css( 'display', 'none' );

            if ( variation.price_html ) {

                if ( !$product.find( '.price-cloned' ).length ) {
                    $product.append( $price_clone );
                }

                $price.replaceWith( variation.price_html );
            } else {
                if ( $product.find( '.price-cloned' ).length ) {
                    $price.replaceWith( $price_clone.html() );
                    $price_clone.remove();
                }
            }

            // add variation id
            $swatches.attr( 'data-variation_id', variation.variation_id );

            // update image
            self.variationsImageUpdate( variation, $product );
        },
        variationsImageUpdate: function( variation, $product ) {

            var self = this,
                $product_img = $product.find( '.g5shop__product-thumbnail img' ),
                $product_bg = $product.find('.g5shop__product-thumbnail .g5core__entry-thumbnail');

            if ($product.find('.g5shop__product-thumb-secondary').length) {
                $product_img = $product.find( '.g5shop__product-thumb-secondary img' );
                $product_bg = $product.find( '.g5shop__product-thumb-secondary .g5core__entry-thumbnail' );
            }

            if ( variation && variation.image.thumb_src ) {

                if ($product_img.length) {
                    self.setVariationAttr( $product_img, 'src',variation.image.thumb_src );
                    self.setVariationAttr( $product_img, 'srcset',variation.image.thumb_src );
                    self.setVariationAttr( $product_img, 'sizes',variation.image.sizes );
                } else {
                    self.setVariationAttr( $product_bg, 'style','background-image: url(' +variation.image.thumb_src  + ')' );
                }


            } else {
                if ($product_img.length) {
                    self.resetVariationAttr( $product_img, 'src' );
                    self.resetVariationAttr( $product_img, 'srcset' );
                    self.resetVariationAttr( $product_img, 'sizes' );
                } else {
                    self.resetVariationAttr( $product_bg, 'style' );
                }

            }
        },
        setVariationAttr: function ( $el, attr, value ) {
            if ( undefined === $el.attr( 'data-o_' + attr ) ) {
                $el.attr( 'data-o_' + attr, (
                    !$el.attr( attr )
                ) ? '' : $el.attr( attr ) );
            }
            if ( false === value ) {
                $el.removeAttr( attr );
            }
            else {
                $el.attr( attr, value );
            }
        },
        resetVariationAttr: function ( $el, attr ) {
            if ( undefined !== $el.attr( 'data-o_' + attr ) ) {
                $el.attr( attr, $el.attr( 'data-o_' + attr ) );
            }
        },
        initSingle: function() {
            var self = this,
                $form = $('.g5shop__single-swatches'),
                $term = $form.find( '.g5shop__swatches-item' ),
                $activeTerm = $form.find('.g5shop__swatches-item:not(.g5shop__sw-disabled)' );

            // load default value
            $term.each( function() {
                var $this = $( this ),
                    term = $this.attr( 'data-term' ),
                    attr = $this.parent().attr( 'data-attribute' ),
                    $selectbox = $form.find( 'select#' + attr ),
                    val = $selectbox.val();

                if ( val != '' && term == val ) {
                    $( this ).addClass( 'g5shop__sw-selected' );
                }
            } );

            $activeTerm.unbind( 'click' ).on( 'click', function( e ) {
                var $this = $( this ),
                    term = $this.attr( 'data-term' ),
                    title = $this.attr( 'title' ),
                    attr = $this.parent().attr( 'data-attribute' ),
                    $selectbox = $form.find( 'select#' + attr );

                if ( $this.hasClass( 'g5shop__sw-disabled' ) ) {
                    return false;
                }

                $selectbox.val( term ).trigger( 'change' );

                $this.parent( '.g5shop__swatch' ).find( '.g5shop__sw-selected' ).removeClass( 'g5shop__sw-selected' );
                $this.addClass( 'g5shop__sw-selected' );

                $( 'body' ).trigger( 'g5shop__sw_selected', [attr, term, title] );

                e.preventDefault();
            } );


            $form.on( 'woocommerce_update_variation_values',function () {
                $form.find( 'select' ).each( function() {
                    var $this = $( this );
                        var $swatch = $this.parent().find( '.g5shop__swatch' );

                    $swatch.find( '.g5shop__swatches-item' ).removeClass( 'g5shop__sw-enabled' ).addClass( 'g5shop__sw-disabled' );

                    $this.find( 'option.enabled' ).each( function() {
                        var val = $( this ).val();
                        $swatch.find(
                            '.g5shop__swatches-item[data-term="' + val + '"]' ).removeClass( 'g5shop__sw-disabled' ).addClass( 'g5shop__sw-enabled' );
                    } );
                } );
            } );

            $form.on( 'reset_data', function() {
                $( this ).find( '.g5shop__sw-selected' ).removeClass( 'g5shop__sw-selected' );
                $( this ).find( 'select' ).each( function() {
                    var attr = $( this ).attr( 'id' );
                    var title = $( this ).find( 'option:selected' ).text();
                    var term = $( this ).val();
                    if ( term != '' ) {
                        $( this ).parent().find( '.g5shop__swatches-item[data-term="' + term + '"]' ).addClass( 'g5shop__sw-selected' );
                        $( 'body' ).trigger( 'g5shop__sw_reset_attr', [attr, term, title] );
                    }
                } );

            } );






        },
        updateAjaxSuccess: function () {
            var self = this;
            $body.on('g5core_pagination_ajax_success', function (event, _data, $ajaxHTML, target, loadMore) {
                if (_data.settings['post_type'] === 'product') {
                    self.initLoop();
                }
            });
        },
        updateQuickViewSuccess: function () {
            var self = this;
            $body.on('g5shop_product_quick_view_success', function (event) {
                self.initSingle();
            });
        }
    };

    $(document).ready(function () {
        G5SHOP_SWATCHES.init();
    });

})(jQuery);