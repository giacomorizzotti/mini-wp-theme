(function (blocks, element, blockEditor, components, i18n) {
    var el             = element.createElement;
    var Fragment       = element.Fragment;
    var useBlockProps  = blockEditor.useBlockProps;
    var InnerBlocks    = blockEditor.InnerBlocks;
    var InspectorControls = blockEditor.InspectorControls;
    var PanelBody      = components.PanelBody;
    var SelectControl  = components.SelectControl;
    var __             = i18n.__;

    var AOS_ANIMATIONS = [
        { label: __('None', 'mini'),             value: '' },
        { label: '— Fade —',                     value: '', disabled: true },
        { label: 'fade',                         value: 'fade' },
        { label: 'fade-up',                      value: 'fade-up' },
        { label: 'fade-down',                    value: 'fade-down' },
        { label: 'fade-left',                    value: 'fade-left' },
        { label: 'fade-right',                   value: 'fade-right' },
        { label: 'fade-up-right',                value: 'fade-up-right' },
        { label: 'fade-up-left',                 value: 'fade-up-left' },
        { label: 'fade-down-right',              value: 'fade-down-right' },
        { label: 'fade-down-left',               value: 'fade-down-left' },
        { label: '— Flip —',                     value: '', disabled: true },
        { label: 'flip-left',                    value: 'flip-left' },
        { label: 'flip-right',                   value: 'flip-right' },
        { label: 'flip-up',                      value: 'flip-up' },
        { label: 'flip-down',                    value: 'flip-down' },
        { label: '— Slide —',                    value: '', disabled: true },
        { label: 'slide-up',                     value: 'slide-up' },
        { label: 'slide-down',                   value: 'slide-down' },
        { label: 'slide-left',                   value: 'slide-left' },
        { label: 'slide-right',                  value: 'slide-right' },
        { label: '— Zoom —',                     value: '', disabled: true },
        { label: 'zoom-in',                      value: 'zoom-in' },
        { label: 'zoom-in-up',                   value: 'zoom-in-up' },
        { label: 'zoom-in-down',                 value: 'zoom-in-down' },
        { label: 'zoom-in-left',                 value: 'zoom-in-left' },
        { label: 'zoom-in-right',                value: 'zoom-in-right' },
        { label: 'zoom-out',                     value: 'zoom-out' },
        { label: 'zoom-out-up',                  value: 'zoom-out-up' },
        { label: 'zoom-out-down',                value: 'zoom-out-down' },
        { label: 'zoom-out-left',                value: 'zoom-out-left' },
        { label: 'zoom-out-right',               value: 'zoom-out-right' },
    ];

    var AOS_DELAYS = [
        { label: __('None', 'mini'), value: '' },
        { label: '50ms',   value: '50'   }, { label: '100ms', value: '100' },
        { label: '150ms',  value: '150'  }, { label: '200ms', value: '200' },
        { label: '250ms',  value: '250'  }, { label: '300ms', value: '300' },
        { label: '400ms',  value: '400'  }, { label: '500ms', value: '500' },
        { label: '600ms',  value: '600'  }, { label: '800ms', value: '800' },
        { label: '1000ms', value: '1000' },
    ];

    var AOS_DURATIONS = [
        { label: __('Default (400ms)', 'mini'), value: '' },
        { label: '200ms',  value: '200'  }, { label: '400ms',  value: '400'  },
        { label: '600ms',  value: '600'  }, { label: '800ms',  value: '800'  },
        { label: '1000ms', value: '1000' }, { label: '1200ms', value: '1200' },
        { label: '1500ms', value: '1500' }, { label: '2000ms', value: '2000' },
    ];

    var AOS_OFFSETS = [
        { label: __('Default (120px)', 'mini'), value: '' },
        { label: '0px',   value: '0'   }, { label: '50px',  value: '50'  },
        { label: '100px', value: '100' }, { label: '150px', value: '150' },
        { label: '200px', value: '200' }, { label: '250px', value: '250' },
        { label: '300px', value: '300' },
    ];

    blocks.registerBlockType('mini/box', {
        edit: function (props) {
            var width        = props.attributes.width   || '50';
            var padding      = props.attributes.padding !== undefined ? props.attributes.padding : '';
            var aosAnimation = props.attributes.aosAnimation || '';
            var aosDelay     = props.attributes.aosDelay     || '';
            var aosDuration  = props.attributes.aosDuration  || '';
            var aosOffset    = props.attributes.aosOffset    || '';
            var clientId     = props.clientId;
            var setAttributes = props.setAttributes;
            var aosEnabled   = window.miniBlocksData && window.miniBlocksData.aosEnabled;

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
                Fragment, null,
                el(InspectorControls, null,
                    el(PanelBody, { title: __('Box settings', 'mini'), initialOpen: true },
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
                        })
                    ),
                    aosEnabled && el(PanelBody, { title: __('Animation (AOS)', 'mini'), initialOpen: false },
                        el(SelectControl, {
                            label: __('Animation', 'mini'),
                            value: aosAnimation,
                            options: AOS_ANIMATIONS,
                            onChange: function (val) { setAttributes({ aosAnimation: val }); }
                        }),
                        el(SelectControl, {
                            label: __('Delay', 'mini'),
                            value: aosDelay,
                            options: AOS_DELAYS,
                            onChange: function (val) { setAttributes({ aosDelay: val }); }
                        }),
                        el(SelectControl, {
                            label: __('Duration', 'mini'),
                            value: aosDuration,
                            options: AOS_DURATIONS,
                            onChange: function (val) { setAttributes({ aosDuration: val }); }
                        }),
                        el(SelectControl, {
                            label: __('Offset', 'mini'),
                            value: aosOffset,
                            options: AOS_OFFSETS,
                            onChange: function (val) { setAttributes({ aosOffset: val }); }
                        })
                    )
                ),
                el( 'style', null, boxStyleTag ),
                el('div', blockProps,
                    el('div', {
                        style: {
                            fontSize: '10px', fontWeight: '600',
                            color: '#7b6fc4', marginBottom: '4px',
                            textTransform: 'uppercase',
                        }
                    }, el('i', { className: 'iconoir-box-iso' }), ' box-' + width + (padding !== '' ? '  p-' + padding : '') + (aosAnimation ? '  ✦ ' + aosAnimation : '')),
                    el(InnerBlocks, null)
                )
            );
        },
        save: function () {
            return el(InnerBlocks.Content, null);
        }
    });

}(window.wp.blocks, window.wp.element, window.wp.blockEditor, window.wp.components, window.wp.i18n));
