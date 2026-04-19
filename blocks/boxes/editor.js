(function (blocks, element, blockEditor, components, i18n) {
    var el                  = element.createElement;
    var Fragment            = element.Fragment;
    var useBlockProps       = blockEditor.useBlockProps;
    var useInnerBlocksProps = blockEditor.useInnerBlocksProps;
    var InspectorControls   = blockEditor.InspectorControls;
    var PanelBody           = components.PanelBody;
    var SelectControl       = components.SelectControl;
    var TextControl         = components.TextControl;
    var ToggleControl       = components.ToggleControl;
    var __                  = i18n.__;  

    blocks.registerBlockType('mini/boxes', {
        edit: function (props) {
            var flexDirection  = props.attributes.flexDirection  || '';
            var flexWrap       = props.attributes.flexWrap       || '';
            var justifyContent = props.attributes.justifyContent || '';
            var alignContent   = props.attributes.alignContent   || '';
            var alignItems     = props.attributes.alignItems     || '';
            var heightClass    = props.attributes.heightClass    || '';
            var gapClass       = props.attributes.gapClass       || '';
            var spaceTop       = props.attributes.spaceTop       || false;
            var spaceBot       = props.attributes.spaceBot       || false;
            var setAttributes  = props.setAttributes;
            var clientId       = props.clientId;

            var directionMap = {
                '': 'row',
                'flex-direction-row': 'row',
                'flex-direction-row-reverse': 'row-reverse',
                'flex-direction-column': 'column',
                'flex-direction-column-reverse': 'column-reverse',
            };
            var wrapMap = {
                '': 'wrap',
                'flex-wrap': 'wrap',
                'flex-no-wrap': 'nowrap',
            };
            var justifyMap = {
                '': '',
                'justify-content-start':   'flex-start',
                'justify-content-end':     'flex-end',
                'justify-content-center':  'center',
                'justify-content-between': 'space-between',
                'justify-content-around':  'space-around',
            };
            var alignContentMap = {
                '': '',
                'align-content-start':   'flex-start',
                'align-content-end':     'flex-end',
                'align-content-center':  'center',
                'align-content-stretch': 'stretch',
                'align-content-between': 'space-between',
                'align-content-around':  'space-around',
            };
            var alignItemsMap = {
                '': 'flex-start',
                'align-items-start':   'flex-start',
                'align-items-end':     'flex-end',
                'align-items-center':  'center',
                'align-items-stretch': 'stretch',
            };

            // Gap: map class value → CSS calc for --gap-x/--gap-y preview
            var gapMultiplierMap = {
                '': null, 'g-0': 0, 'g-05': 0.5, 'g-1': 1, 'g-15': 1.5,
                'g-2': 2, 'g-3': 3, 'g-4': 4, 'g-5': 5, 'g-10': 10, 'g-20': 20,
            };
            var gapVal = gapMultiplierMap[ gapClass ] !== undefined && gapMultiplierMap[ gapClass ] !== null
                ? 'calc(10px * ' + gapMultiplierMap[ gapClass ] + ')'
                : '10px'; // matches --basic-gap default

            // Build CSS injected directly into .block-editor-block-list__layout
            // (Gutenberg's own intermediate wrapper inside useInnerBlocksProps)
            var layoutCSS = [
                'display: flex !important',
                // Reset Gutenberg's grid layout which causes centering
                'grid-template-columns: unset !important',
                'justify-items: initial !important',
                'flex-direction: ' + ( directionMap[ flexDirection ] || 'row' ) + ' !important',
                'flex-wrap: ' + ( wrapMap[ flexWrap ] || 'wrap' ) + ' !important',
                'justify-content: ' + ( justifyMap[ justifyContent ] || 'flex-start' ) + ' !important',
                alignContentMap[ alignContent ] ? 'align-content: ' + alignContentMap[ alignContent ] + ' !important' : '',
                'align-items: ' + ( alignItemsMap[ alignItems ] || 'flex-start' ) + ' !important',
                'gap: ' + gapVal + ' ' + gapVal + ' !important',
            ].filter( Boolean ).join( '; ' );

            var styleTag = [
                '#block-' + clientId + ' .block-editor-block-list__layout {',
                '  ' + layoutCSS,
                '}',
                // Reset Gutenberg's forced full-width on each block wrapper so justify-content works
                '#block-' + clientId + ' .block-editor-block-list__layout > [data-block] {',
                '  width: auto !important; max-width: none !important; min-width: 0 !important;',
                '  justify-self: initial !important; margin: 0 !important;',
                '}',
            ].join('\n');

            // Height still applied to the wrapper element
            var heightStyleMap = {
                '':       {},
                'fh':     { minHeight: '100vh'   },
                'fhf':    { height:    '100vh'   },
                'hh':     { minHeight: '50vh'    },
                'hhf':    { height:    '50vh'    },
                'h25':    { minHeight: '25vh'    },
                'h25f':   { height:    '25vh'    },
                'h33':    { minHeight: '33.33vh' },
                'h33f':   { height:    '33.33vh' },
                'h66':    { minHeight: '66.67vh' },
                'h66f':   { height:    '66.67vh' },
                'h75':    { minHeight: '75vh'    },
                'h75f':   { height:    '75vh'    },
                'mh-100': { minHeight: '100%'    },
                'h-100':  { height:    '100%'    },
            };

            var blockProps = useBlockProps({
                style: {
                    border: '2px dashed #7b6fc4',
                    borderRadius: '4px',
                    padding: '8px',
                }
            });

            var innerBlocksProps = useInnerBlocksProps(
                { style: Object.assign( {}, heightStyleMap[ heightClass ] || {} ) },
                {
                    allowedBlocks: ['mini/box'],
                    template: [
                        ['mini/box', { width: '50' }],
                        ['mini/box', { width: '50' }],
                    ],
                }
            );

            return el(
                Fragment,
                null,
                el( 'style', null, styleTag ),
                el(
                    InspectorControls,
                    null,
                    el(
                        PanelBody,
                        { title: __( 'Flex layout', 'mini' ), initialOpen: true },
                        el(SelectControl, {
                            label: __( 'Direction', 'mini' ),
                            value: flexDirection,
                            options: [
                                { label: __( 'Default (row)', 'mini' ),  value: '' },
                                { label: 'Row',                          value: 'flex-direction-row' },
                                { label: 'Row reverse',                  value: 'flex-direction-row-reverse' },
                                { label: 'Column',                       value: 'flex-direction-column' },
                                { label: 'Column reverse',               value: 'flex-direction-column-reverse' },
                            ],
                            onChange: function (v) { setAttributes({ flexDirection: v }); }
                        }),
                        el(SelectControl, {
                            label: __( 'Wrap', 'mini' ),
                            value: flexWrap,
                            options: [
                                { label: __( 'Default', 'mini' ), value: '' },
                                { label: 'Wrap',                  value: 'flex-wrap' },
                                { label: 'No wrap',               value: 'flex-no-wrap' },
                            ],
                            onChange: function (v) { setAttributes({ flexWrap: v }); }
                        }),
                        el(SelectControl, {
                            label: __( 'Justify content', 'mini' ),
                            value: justifyContent,
                            options: [
                                { label: __( 'Default', 'mini' ), value: '' },
                                { label: 'Start',                 value: 'justify-content-start' },
                                { label: 'End',                   value: 'justify-content-end' },
                                { label: 'Center',                value: 'justify-content-center' },
                                { label: 'Space between',         value: 'justify-content-between' },
                                { label: 'Space around',          value: 'justify-content-around' },
                            ],
                            onChange: function (v) { setAttributes({ justifyContent: v }); }
                        }),
                        el(SelectControl, {
                            label: __( 'Align content', 'mini' ),
                            value: alignContent,
                            options: [
                                { label: __( 'Default', 'mini' ), value: '' },
                                { label: 'Start',                 value: 'align-content-start' },
                                { label: 'End',                   value: 'align-content-end' },
                                { label: 'Center',                value: 'align-content-center' },
                                { label: 'Stretch',               value: 'align-content-stretch' },
                                { label: 'Space between',         value: 'align-content-between' },
                                { label: 'Space around',          value: 'align-content-around' },
                            ],
                            onChange: function (v) { setAttributes({ alignContent: v }); }
                        }),
                        el(SelectControl, {
                            label: __( 'Align items', 'mini' ),
                            value: alignItems,
                            options: [
                                { label: __( 'Default', 'mini' ), value: '' },
                                { label: 'Start',                 value: 'align-items-start' },
                                { label: 'End',                   value: 'align-items-end' },
                                { label: 'Center',                value: 'align-items-center' },
                                { label: 'Stretch',               value: 'align-items-stretch' },
                            ],
                            onChange: function (v) { setAttributes({ alignItems: v }); }
                        }),
                        el(SelectControl, {
                            label: __( 'Height', 'mini' ),
                            value: heightClass,
                            options: [
                                { label: __( 'Default', 'mini' ),        value: ''      },
                                { label: 'Min 100vh  (fh)',               value: 'fh'    },
                                { label: 'Fixed 100vh  (fhf)',            value: 'fhf'   },
                                { label: 'Min 75vh  (h75)',               value: 'h75'   },
                                { label: 'Fixed 75vh  (h75f)',            value: 'h75f'  },
                                { label: 'Min 66vh  (h66)',               value: 'h66'   },
                                { label: 'Fixed 66vh  (h66f)',            value: 'h66f'  },
                                { label: 'Min 50vh  (hh)',                value: 'hh'    },
                                { label: 'Fixed 50vh  (hhf)',             value: 'hhf'   },
                                { label: 'Min 33vh  (h33)',               value: 'h33'   },
                                { label: 'Fixed 33vh  (h33f)',            value: 'h33f'  },
                                { label: 'Min 25vh  (h25)',               value: 'h25'   },
                                { label: 'Fixed 25vh  (h25f)',            value: 'h25f'  },
                                { label: 'Min 100%  (mh-100)',            value: 'mh-100'},
                                { label: 'Fixed 100%  (h-100)',           value: 'h-100' },
                            ],
                            onChange: function (v) { setAttributes({ heightClass: v }); }
                        }),
                        el(SelectControl, {
                            label: __( 'Gap', 'mini' ),
                            value: gapClass,
                            options: [
                                { label: __( 'Default (g-1)', 'mini' ), value: ''     },
                                { label: '0  (g-0)',                    value: 'g-0'  },
                                { label: '0.5× (g-05)',                 value: 'g-05' },
                                { label: '1× (g-1)',                    value: 'g-1'  },
                                { label: '1.5× (g-15)',                 value: 'g-15' },
                                { label: '2× (g-2)',                    value: 'g-2'  },
                                { label: '3× (g-3)',                    value: 'g-3'  },
                                { label: '4× (g-4)',                    value: 'g-4'  },
                                { label: '5× (g-5)',                    value: 'g-5'  },
                                { label: '10× (g-10)',                  value: 'g-10' },
                                { label: '20× (g-20)',                  value: 'g-20' },
                            ],
                            onChange: function (v) { setAttributes({ gapClass: v }); }
                        }),
                        el(ToggleControl, {
                            label: __( 'Space top', 'mini' ),
                            help: __( 'Adds .space-top (padding-top for fixed menu offset).', 'mini' ),
                            checked: spaceTop,
                            onChange: function (v) { setAttributes({ spaceTop: v }); }
                        }),
                        el(ToggleControl, {
                            label: __( 'Space bottom', 'mini' ),
                            help: __( 'Adds .space-bot (padding-bottom for fixed menu offset).', 'mini' ),
                            checked: spaceBot,
                            onChange: function (v) { setAttributes({ spaceBot: v }); }
                        })
                    )
                ),
                el(
                    'div',
                    blockProps,
                    el('div', {
                        style: {
                            fontSize: '11px', fontWeight: '600',
                            color: '#7b6fc4', marginBottom: '6px',
                            letterSpacing: '0.05em', textTransform: 'uppercase',
                            flexBasis: '100%',
                        }
                    }, el('i', { className: 'iconoir-packages' }), ' Boxes'),
                    el('div', innerBlocksProps)
                )
            );
        },

        save: function () {
            return el(blockEditor.InnerBlocks.Content, null);
        }
    });

}(window.wp.blocks, window.wp.element, window.wp.blockEditor, window.wp.components, window.wp.i18n));
