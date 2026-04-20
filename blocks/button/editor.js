(function (blocks, element, blockEditor, components, i18n) {
    var el             = element.createElement;
    var Fragment       = element.Fragment;
    var useBlockProps  = blockEditor.useBlockProps;
    var InspectorControls = blockEditor.InspectorControls;
    var PanelBody      = components.PanelBody;
    var TextControl    = components.TextControl;
    var SelectControl  = components.SelectControl;
    var ToggleControl  = components.ToggleControl;
    var __             = i18n.__;

    var COLOR_OPTIONS = [
        { label: 'None (link color)',  value: ''             },
        { label: 'Main color',        value: 'main-color'    },
        { label: 'Second color',      value: 'second-color'  },
        { label: 'Third color',       value: 'third-color'   },
        { label: 'Fourth color',      value: 'fourth-color'  },
        { label: 'Fifth color',       value: 'fifth-color'   },
        { label: 'Dark',              value: 'dark'          },
        { label: 'Light grey',        value: 'light-grey'    },
        { label: 'White',             value: 'white'         },
        { label: 'Success (green)',   value: 'success'       },
        { label: 'Warning (orange)',  value: 'warning'       },
        { label: 'Danger (red)',      value: 'danger'        },
    ];

    blocks.registerBlockType('mini/button', {
        edit: function (props) {
            var label        = props.attributes.label        || 'Click here';
            var url          = props.attributes.url          || '';
            var color        = props.attributes.color !== undefined ? props.attributes.color : '';
            var size         = props.attributes.size         || '';
            var openInNewTab = props.attributes.openInNewTab || false;
            var invert       = props.attributes.invert       || false;
            var transpBg     = props.attributes.transpBg     || false;
            var setAttributes = props.setAttributes;

            var blockProps = useBlockProps({ style: { display: 'inline-block' } });

            var colorClass = color ? color + '-btn' + (invert ? '-invert' : '') : '';
            var btnClass = ['btn', size, colorClass, transpBg ? 'transp-bg' : ''].filter(Boolean).join(' ');

            return el(
                Fragment,
                null,
                el(
                    InspectorControls,
                    null,
                    el(
                        PanelBody,
                        { title: __('Button settings', 'mini'), initialOpen: true },
                        el(TextControl, {
                            label: __('Label', 'mini'),
                            value: label,
                            onChange: function (val) { setAttributes({ label: val }); }
                        }),
                        el(TextControl, {
                            label: __('URL', 'mini'),
                            value: url,
                            type: 'url',
                            onChange: function (val) { setAttributes({ url: val }); }
                        }),
                        el(SelectControl, {
                            label: __('Color', 'mini'),
                            value: color,
                            options: COLOR_OPTIONS,
                            onChange: function (val) { setAttributes({ color: val }); }
                        }),
                        el(SelectControl, {
                            label: __('Size', 'mini'),
                            value: size,
                            options: [
                                { label: __('Normal', 'mini'), value: ''  },
                                { label: __('Small',  'mini'), value: 'S' },
                                { label: __('Large',  'mini'), value: 'L' },
                            ],
                            onChange: function (val) { setAttributes({ size: val }); }
                        }),
                        el(ToggleControl, {
                            label: __('Open in new tab', 'mini'),
                            checked: openInNewTab,
                            onChange: function (val) { setAttributes({ openInNewTab: val }); }
                        }),
                        el(ToggleControl, {
                            label: __('Invert color', 'mini'),
                            help: __('Adds -invert suffix to the color class.', 'mini'),
                            checked: invert,
                            onChange: function (val) { setAttributes({ invert: val }); }
                        }),
                        el(ToggleControl, {
                            label: __('Transparent background', 'mini'),
                            help: __('Adds transp-bg class.', 'mini'),
                            checked: transpBg,
                            onChange: function (val) { setAttributes({ transpBg: val }); }
                        })
                    )
                ),
                el(
                    'span',
                    blockProps,
                    el('span', { className: btnClass }, label || __('(empty label)', 'mini'))
                )
            );
        },

        save: function () {
            return null;
        }
    });

}(window.wp.blocks, window.wp.element, window.wp.blockEditor, window.wp.components, window.wp.i18n));
