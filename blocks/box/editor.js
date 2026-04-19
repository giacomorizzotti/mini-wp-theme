(function (blocks, element, blockEditor, components, i18n) {
    var el             = element.createElement;
    var Fragment       = element.Fragment;
    var useBlockProps  = blockEditor.useBlockProps;
    var InnerBlocks    = blockEditor.InnerBlocks;
    var InspectorControls = blockEditor.InspectorControls;
    var PanelBody      = components.PanelBody;
    var SelectControl  = components.SelectControl;
    var __             = i18n.__;

    blocks.registerBlockType('mini/box', {
        edit: function (props) {
            var width        = props.attributes.width   || '50';
            var padding      = props.attributes.padding !== undefined ? props.attributes.padding : '';
            var clientId     = props.clientId;
            var setAttributes = props.setAttributes;

            // Inject width on [data-block] — the actual flex item Gutenberg wraps each block in
            var boxStyleTag = '[data-block="' + clientId + '"] {' +
                'flex: 0 1 calc(' + width + '% - 10px) !important;' +
                'min-width: 0 !important;' +
                'box-sizing: border-box !important;' +
            '}';

            var blockProps = useBlockProps({
                style: {
                    border: '1px dashed #7b6fc4',
                    borderRadius: '4px',
                    padding: '8px',
                    minHeight: '48px',
                    boxSizing: 'border-box',
                    width: '100%',
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
                        { title: __('Box settings', 'mini'), initialOpen: true },
                        el(SelectControl, {
                            label: __('Width', 'mini'),
                            value: width,
                            options: [
                                { label: '8%   (box-8)',   value: '8'   },
                                { label: '10%  (box-10)',  value: '10'  },
                                { label: '12%  (box-12)',  value: '12'  },
                                { label: '15%  (box-15)',  value: '15'  },
                                { label: '16%  (box-16)',  value: '16'  },
                                { label: '20%  (box-20)',  value: '20'  },
                                { label: '25%  (box-25)',  value: '25'  },
                                { label: '30%  (box-30)',  value: '30'  },
                                { label: '33%  (box-33)',  value: '33'  },
                                { label: '40%  (box-40)',  value: '40'  },
                                { label: '50%  (box-50)',  value: '50'  },
                                { label: '60%  (box-60)',  value: '60'  },
                                { label: '66%  (box-66)',  value: '66'  },
                                { label: '70%  (box-70)',  value: '70'  },
                                { label: '75%  (box-75)',  value: '75'  },
                                { label: '80%  (box-80)',  value: '80'  },
                                { label: '88%  (box-88)',  value: '88'  },
                                { label: '90%  (box-90)',  value: '90'  },
                                { label: '100% (box-100)', value: '100' },
                            ],
                            onChange: function (val) { setAttributes({ width: val }); }
                        }),
                        el(SelectControl, {
                            label: __('Padding', 'mini'),
                            value: padding,
                            options: [
                                { label: __('Default (p-1)', 'mini'), value: ''  },
                                { label: '0 (p-0)',                   value: '0' },
                                { label: '1 (p-1)',                   value: '1' },
                                { label: '2 (p-2)',                   value: '2' },
                                { label: '3 (p-3)',                   value: '3' },
                                { label: '4 (p-4)',                   value: '4' },
                                { label: '5 (p-5)',                   value: '5' },
                            ],
                            onChange: function (val) { setAttributes({ padding: val }); }
                        }),
                    )
                ),
                el( 'style', null, boxStyleTag ),
                el(
                    'div',
                    blockProps,
                    el('div', {
                        style: {
                            fontSize: '10px', fontWeight: '600',
                            color: '#7b6fc4', marginBottom: '4px',
                            textTransform: 'uppercase',
                        }
                    }, el('i', { className: 'iconoir-box-iso' }), ' box-' + width + (padding !== '' ? '  p-' + padding : '')),
                    el(InnerBlocks, null)
                )
            );
        },

        save: function () {
            return el(InnerBlocks.Content, null);
        }
    });

}(window.wp.blocks, window.wp.element, window.wp.blockEditor, window.wp.components, window.wp.i18n));
