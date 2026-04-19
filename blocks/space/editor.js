(function (blocks, element, blockEditor, components, i18n) {
    var el            = element.createElement;
    var Fragment      = element.Fragment;
    var useBlockProps = blockEditor.useBlockProps;
    var InspectorControls = blockEditor.InspectorControls;
    var PanelBody     = components.PanelBody;
    var SelectControl = components.SelectControl;
    var __            = i18n.__;

    var SIZE_OPTIONS = [
        { label: '0.5x (space-05)',  value: '05'  },
        { label: '1x (space-1)',    value: '1'   },
        { label: '1.5x (space-15)',   value: '15'  },
        { label: '2x (space-2)',    value: '2'   },
        { label: '2.5x (space-25)',   value: '25'  },
        { label: '3x (space-3)',    value: '3'   },
        { label: '4x (space-4)',    value: '4'   },
        { label: '5x (space-5)',    value: '5'   },
        { label: '6x (space-6)',    value: '6'   },
        { label: '10x (space-10)',   value: '10'  },
        { label: '20x (space-20)',   value: '20'  },
    ];

    blocks.registerBlockType('mini/space', {
        edit: function (props) {
            var size         = props.attributes.size || '1';
            var setAttributes = props.setAttributes;
            var className    = size === '1' ? 'space' : 'space-' + size;

            var blockProps = useBlockProps({
                style: {
                    display: 'block',
                    width: '100%',
                    background: 'repeating-linear-gradient(45deg, #e8e0ff, #e8e0ff 2px, transparent 2px, transparent 8px)',
                    minHeight: '12px',
                    borderRadius: '2px',
                    boxSizing: 'border-box',
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
                        { title: __('Space settings', 'mini'), initialOpen: true },
                        el(SelectControl, {
                            label: __('Size', 'mini'),
                            value: size,
                            options: SIZE_OPTIONS,
                            onChange: function (val) { setAttributes({ size: val }); }
                        })
                    )
                ),
                el(
                    'div',
                    blockProps,
                    el('span', {
                        style: {
                            fontSize: '10px', fontWeight: '600',
                            color: '#7b6fc4', padding: '2px 6px',
                            display: 'block', textTransform: 'uppercase',
                        }
                    }, className)
                )
            );
        },

        save: function () { return null; }
    });

}(window.wp.blocks, window.wp.element, window.wp.blockEditor, window.wp.components, window.wp.i18n));
