(function (blocks, element, blockEditor, components, i18n) {
    var el            = element.createElement;
    var Fragment      = element.Fragment;
    var useBlockProps = blockEditor.useBlockProps;
    var InspectorControls = blockEditor.InspectorControls;
    var PanelBody     = components.PanelBody;
    var SelectControl = components.SelectControl;
    var __            = i18n.__;

    var SIZE_OPTIONS = [
        { label: __('Default (sep)',  'mini'), value: ''   },
        { label: __('0px (sep-0)',     'mini'), value: '0'  },
        { label: __('1px (sep-1)',     'mini'), value: '1'  },
        { label: __('2px (sep-2)',     'mini'), value: '2'  },
        { label: __('3px (sep-3)',     'mini'), value: '3'  },
        { label: __('4px (sep-4)',     'mini'), value: '4'  },
        { label: __('5px (sep-5)',     'mini'), value: '5'  },
        { label: __('10px (sep-10)',   'mini'), value: '10' },
    ];

    var COLOR_OPTIONS = [
        { label: __('None',              'mini'), value: ''                   },
        { label: __('False white',       'mini'), value: 'false-white-border' },
        { label: __('Light grey',        'mini'), value: 'light-grey-border'  },
        { label: __('Grey',              'mini'), value: 'grey-border'        },
        { label: __('Dark grey',         'mini'), value: 'dark-grey-border'   },
        { label: __('False black',       'mini'), value: 'false-black-border' },
        { label: __('Black',             'mini'), value: 'black-border'       },
        { label: __('White',             'mini'), value: 'white-border'       },
        { label: __('Main color',        'mini'), value: 'main-color-border'  },
        { label: __('Second color',      'mini'), value: 'second-color-border'},
        { label: __('Third color',       'mini'), value: 'third-color-border' },
        { label: __('Fourth color',      'mini'), value: 'fourth-color-border' },
    ];

    blocks.registerBlockType('mini/sep', {
        edit: function (props) {
            var size         = props.attributes.size        || '';
            var colorClass   = props.attributes.colorClass  || '';
            var setAttributes = props.setAttributes;

            var baseClass = size === '' ? 'sep' : 'sep-' + size;
            var previewClasses = [baseClass, colorClass].filter(Boolean).join(' ');

            var blockProps = useBlockProps({ style: { display: 'block' } });

            return el(
                Fragment,
                null,
                el(
                    InspectorControls,
                    null,
                    el(
                        PanelBody,
                        { title: __('Sep settings', 'mini'), initialOpen: true },
                        el(SelectControl, {
                            label: __('Height', 'mini'),
                            value: size,
                            options: SIZE_OPTIONS,
                            onChange: function (val) { setAttributes({ size: val }); }
                        }),
                        el(SelectControl, {
                            label: __('Border color', 'mini'),
                            value: colorClass,
                            options: COLOR_OPTIONS,
                            onChange: function (val) { setAttributes({ colorClass: val }); }
                        })
                    )
                ),
                el(
                    'div',
                    blockProps,
                    el('div', {
                        style: {
                            borderTop: colorClass ? '1px solid currentColor' : '1px solid #d0c8f0',
                            width: '100%',
                            opacity: colorClass ? 1 : 0.5,
                        }
                    }),
                    el('span', {
                        style: {
                            fontSize: '10px', fontWeight: '600',
                            color: '#9b89e0', display: 'block',
                            textTransform: 'uppercase', marginTop: '2px',
                        }
                    }, previewClasses)
                )
            );
        },

        save: function () { return null; }
    });

}(window.wp.blocks, window.wp.element, window.wp.blockEditor, window.wp.components, window.wp.i18n));
