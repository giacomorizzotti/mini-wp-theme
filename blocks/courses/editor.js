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
    ];

    blocks.registerBlockType('mini/courses', {
        edit: function (props) {
            var attrs        = props.attributes;
            var setAttributes = props.setAttributes;

            var categories = useSelect(function (select) {
                return select('core').getEntityRecords('taxonomy', 'course_category', {
                    per_page: -1, _fields: 'id,name',
                }) || [];
            }, []);

            var catOptions = [{ label: __('All categories', 'mini'), value: 0 }].concat(
                categories.map(function (cat) { return { label: cat.name, value: cat.id }; })
            );

            var blockProps = useBlockProps({
                style: {
                    border: '2px dashed #5ab87e',
                    borderRadius: '4px',
                    padding: '12px',
                    background: '#f7fff9',
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
                        { title: __('Courses settings', 'mini'), initialOpen: true },
                        el(RangeControl, {
                            label: __('Number of courses', 'mini'),
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
                            label: __('Show location', 'mini'),
                            checked: attrs.showLocation,
                            onChange: function (val) { setAttributes({ showLocation: val }); }
                        }),
                        el(ToggleControl, {
                            label: __('Show lessons list', 'mini'),
                            checked: attrs.showLessons,
                            onChange: function (val) { setAttributes({ showLessons: val }); }
                        })
                    )
                ),
                el('div', blockProps,
                    el('p', {
                        style: { margin: 0, fontWeight: '600', color: '#5ab87e', fontSize: '13px' }
                    }, '🎓 ' + __('Courses', 'mini') + ' — ' + attrs.count + ' ' + __('courses', 'mini'))
                )
            );
        },

        save: function () { return null; }
    });

}(window.wp.blocks, window.wp.element, window.wp.blockEditor, window.wp.components, window.wp.data, window.wp.i18n));
