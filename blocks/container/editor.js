(function (blocks, element, blockEditor, components, i18n) {
    var el             = element.createElement;
    var Fragment       = element.Fragment;
    var useBlockProps  = blockEditor.useBlockProps;
    var InnerBlocks    = blockEditor.InnerBlocks;
    var InspectorControls = blockEditor.InspectorControls;
    var PanelBody      = components.PanelBody;
    var SelectControl  = components.SelectControl;
    var ToggleControl  = components.ToggleControl;
    var __             = i18n.__;

    blocks.registerBlockType('mini/container', {
        edit: function (props) {
            var size         = props.attributes.size || '';
            var spaceTop     = props.attributes.spaceTop || false;
            var spaceBot     = props.attributes.spaceBot || false;
            var setAttributes = props.setAttributes;
            var sizeLabel    = size ? 'container.' + size : 'container';

            var blockProps = useBlockProps({
                style: {
                    border: '2px dashed #4a9db5',
                    borderRadius: '4px',
                    padding: '8px',
                }
            });

            return el(
                Fragment,
                null,
                el(
                    InspectorControls,
                    null,
                    el(
                        PanelBody,
                        { title: __('Container settings', 'mini'), initialOpen: true },
                        el(SelectControl, {
                            label: __('Size', 'mini'),
                            value: size,
                            options: [
                                { label: __('Default',         'mini'), value: ''     },
                                { label: __('Full width (fw)', 'mini'), value: 'fw'   },
                                { label: __('Wide',            'mini'), value: 'wide' },
                                { label: __('Thin',            'mini'), value: 'thin' },
                            ],
                            onChange: function (val) { setAttributes({ size: val }); }
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
                    el('div', {
                        style: {
                            fontSize: '11px', fontWeight: '600',
                            color: '#4a9db5', marginBottom: '6px',
                            letterSpacing: '0.05em', textTransform: 'uppercase',
                        }
                    }, el('i', { className: 'iconoir-view-structure-up' }), ' ' + sizeLabel),
                    el(InnerBlocks, null)
                )
            );
        },

        save: function () {
            return el(InnerBlocks.Content, null);
        }
    });

}(window.wp.blocks, window.wp.element, window.wp.blockEditor, window.wp.components, window.wp.i18n));
