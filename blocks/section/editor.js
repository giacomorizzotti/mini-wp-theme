(function (blocks, element, blockEditor, components, i18n) {
    var el             = element.createElement;
    var useBlockProps  = blockEditor.useBlockProps;
    var InnerBlocks    = blockEditor.InnerBlocks;
    var InspectorControls = blockEditor.InspectorControls;
    var PanelBody      = components.PanelBody;
    var TextControl    = components.TextControl;
    var ToggleControl  = components.ToggleControl;
    var SelectControl  = components.SelectControl;
    var __             = i18n.__;

    blocks.registerBlockType('mini/section', {
        edit: function (props) {
            var attributes  = props.attributes;
            var setAttributes = props.setAttributes;

            var sectionId     = attributes.sectionId     || '';
            var menuItemName  = attributes.menuItemName  || '';
            var isPageMenu    = attributes.isPageMenu    || false;
            var size          = attributes.size          || 'fw';
            var bgColor       = attributes.bgColor        || '';
            var spaceTop      = attributes.spaceTop       || false;
            var spaceBot      = attributes.spaceBot       || false;

            var className = ['mini-section-wrap'];
            if (isPageMenu) className.push('page-menu');

            var blockProps = useBlockProps({
                className: className.join(' '),
                style: {
                    border: '2px dashed #7b9cc2',
                    borderRadius: '4px',
                    padding: '8px',
                    position: 'relative',
                }
            });

            return el(
                element.Fragment,
                null,
                el(
                    InspectorControls,
                    null,
                    el(
                        PanelBody,
                        { title: __('Section settings', 'mini'), initialOpen: true },
                        el(TextControl, {
                            label: __('Section ID', 'mini'),
                            help: __('Used as anchor and for the page menu.', 'mini'),
                            value: sectionId,
                            onChange: function (val) { setAttributes({ sectionId: val }); }
                        }),
                        el(ToggleControl, {
                            label: __('Page menu item', 'mini'),
                            help: __('Adds the page-menu class so this section appears in the mini page menu.', 'mini'),
                            checked: isPageMenu,
                            onChange: function (val) { setAttributes({ isPageMenu: val }); }
                        }),
                        el(TextControl, {
                            label: __('Menu item label', 'mini'),
                            help: __('Label shown in the mini page menu (menuItemName).', 'mini'),
                            value: menuItemName,
                            onChange: function (val) { setAttributes({ menuItemName: val }); }
                        }),
                        el(SelectControl, {
                            label: __('Container size', 'mini'),
                            help: __('Controls the inner .container class and its size variant.', 'mini'),
                            value: size,
                            options: [
                                { label: __('Default',        'mini'), value: ''     },
                                { label: __('Full width',     'mini'), value: 'fw'   },
                                { label: __('Wide',           'mini'), value: 'wide' },
                                { label: __('Thin',           'mini'), value: 'thin' },
                                { label: __('No container',   'mini'), value: 'none' },
                            ],
                            onChange: function (val) { setAttributes({ size: val }); }
                        }),
                        el(SelectControl, {
                            label: __('Background color', 'mini'),
                            value: bgColor,
                            options: [
                                { label: __('None',              'mini'), value: ''                    },
                                { label: __('White',             'mini'), value: 'white-bg'            },
                                { label: __('False white',       'mini'), value: 'false-white-bg'       },
                                { label: __('Light grey',        'mini'), value: 'light-grey-bg'        },
                                { label: __('Grey',              'mini'), value: 'grey-bg'              },
                                { label: __('Dark grey',         'mini'), value: 'dark-grey-bg'         },
                                { label: __('False black',       'mini'), value: 'false-black-bg'       },
                                { label: __('Black',             'mini'), value: 'black-bg'             },
                                { label: __('Main color',        'mini'), value: 'main-color-bg'        },
                                { label: __('Second color',      'mini'), value: 'second-color-bg'      },
                                { label: __('Third color',       'mini'), value: 'third-color-bg'       },
                                { label: __('Fourth color',      'mini'), value: 'fourth-color-bg'      },
                                { label: __('— Gradients —',     'mini'), value: '',                    disabled: true },
                                { label: __('1 → 2',             'mini'), value: 'grad-1-to-2'          },
                                { label: __('1 → 3',             'mini'), value: 'grad-1-to-3'          },
                                { label: __('1 → 4',             'mini'), value: 'grad-1-to-4'          },
                                { label: __('2 → 3',             'mini'), value: 'grad-2-to-3'          },
                                { label: __('3 → 4',             'mini'), value: 'grad-3-to-4'          },
                                { label: __('Main',              'mini'), value: 'grad-main'            },
                                { label: __('Second',            'mini'), value: 'grad-second'          },
                                { label: __('Third',             'mini'), value: 'grad-third'           },
                                { label: __('Fourth',            'mini'), value: 'grad-fourth'          },
                                { label: __('False white ↓',     'mini'), value: 'grad-fw-down-w'       },
                                { label: __('False white ↑',     'mini'), value: 'grad-fw-up-w'         },
                            ],
                            onChange: function (val) { setAttributes({ bgColor: val }); }
                        }),
                        el(ToggleControl, {
                            label: __('Space top', 'mini'),
                            help: __('Adds .space-top (padding-top for fixed menu offset).', 'mini'),
                            checked: spaceTop,
                            onChange: function (val) { setAttributes({ spaceTop: val }); }
                        }),
                        el(ToggleControl, {
                            label: __('Space bottom', 'mini'),
                            help: __('Adds .space-bot (padding-bottom for fixed menu offset).', 'mini'),
                            checked: spaceBot,
                            onChange: function (val) { setAttributes({ spaceBot: val }); }
                        })
                    )
                ),
                el(
                    'div',
                    blockProps,
                    el(
                        'div',
                        {
                            style: {
                                fontSize: '11px',
                                fontWeight: '600',
                                color: '#7b9cc2',
                                marginBottom: '6px',
                                letterSpacing: '0.05em',
                                textTransform: 'uppercase',
                            }
                        }, el('i', { className: 'iconoir-hashtag' }), ' Section' + (sectionId ? ' #' + sectionId : '') + (menuItemName ? '  —  ' + menuItemName : '')
                    ),
                    el(InnerBlocks, null)
                )
            );
        },

        save: function () {
            // Rendered server-side via render.php
            return el(InnerBlocks.Content, null);
        }
    });

}(window.wp.blocks, window.wp.element, window.wp.blockEditor, window.wp.components, window.wp.i18n));
