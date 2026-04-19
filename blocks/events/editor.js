(function (blocks, element, blockEditor, components, data, i18n) {
    var el             = element.createElement;
    var Fragment       = element.Fragment;
    var useBlockProps  = blockEditor.useBlockProps;
    var InspectorControls = blockEditor.InspectorControls;
    var PanelBody      = components.PanelBody;
    var RangeControl   = components.RangeControl;
    var SelectControl  = components.SelectControl;
    var ToggleControl  = components.ToggleControl;
    var useSelect      = data.useSelect;
    var __             = i18n.__;

    var COLUMN_OPTIONS = [
        { label: '1 column  (box-100)', value: '100' },
        { label: '2 columns (box-50)',  value: '50'  },
        { label: '3 columns (box-33)',  value: '33'  },
        { label: '4 columns (box-25)',  value: '25'  },
        { label: '5 columns (box-20)',  value: '20'  },
        { label: '6 columns (box-16)',  value: '16'  },
    ];

    blocks.registerBlockType('mini/events', {
        edit: function (props) {
            var attrs        = props.attributes;
            var setAttributes = props.setAttributes;

            var categories = useSelect(function (select) {
                return select('core').getEntityRecords('taxonomy', 'event_category', {
                    per_page: -1, _fields: 'id,name',
                }) || [];
            }, []);

            var catOptions = [{ label: __('All categories', 'mini'), value: 0 }].concat(
                categories.map(function (cat) { return { label: cat.name, value: cat.id }; })
            );

            var blockProps = useBlockProps({
                style: {
                    border: '2px dashed #5a8fd4',
                    borderRadius: '4px',
                    padding: '12px',
                    background: '#f7faff',
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
                        { title: __('Events settings', 'mini'), initialOpen: true },
                        el(RangeControl, {
                            label: __('Number of events', 'mini'),
                            value: attrs.count,
                            min: 1, max: 24,
                            onChange: function (val) { setAttributes({ count: val }); }
                        }),
                        el(SelectControl, {
                            label: __('Columns', 'mini'),
                            value: attrs.columns,
                            options: COLUMN_OPTIONS,
                            onChange: function (val) { setAttributes({ columns: val }); }
                        }),
                        el(SelectControl, {
                            label: __('Category', 'mini'),
                            value: attrs.categoryId,
                            options: catOptions,
                            onChange: function (val) { setAttributes({ categoryId: parseInt(val) || 0 }); }
                        }),
                        el(SelectControl, {
                            label: __('Order', 'mini'),
                            value: attrs.order,
                            options: [
                                { label: __('Date ascending',  'mini'), value: 'ASC'  },
                                { label: __('Date descending', 'mini'), value: 'DESC' },
                            ],
                            onChange: function (val) { setAttributes({ order: val }); }
                        }),
                        el(ToggleControl, {
                            label: __('Upcoming events only', 'mini'),
                            checked: attrs.upcomingOnly,
                            onChange: function (val) { setAttributes({ upcomingOnly: val }); }
                        }),
                        el(ToggleControl, {
                            label: __('Show location', 'mini'),
                            checked: attrs.showLocation,
                            onChange: function (val) { setAttributes({ showLocation: val }); }
                        })
                    )
                ),
                el('div', blockProps,
                    el('p', {
                        style: { margin: 0, fontWeight: '600', color: '#5a8fd4', fontSize: '13px' }
                    }, '📅 ' + __('Events', 'mini') + ' — ' + attrs.count + ' ' + __('events', 'mini') +
                       (attrs.upcomingOnly ? ' (' + __('upcoming', 'mini') + ')' : ''))
                )
            );
        },

        save: function () { return null; }
    });

}(window.wp.blocks, window.wp.element, window.wp.blockEditor, window.wp.components, window.wp.data, window.wp.i18n));
