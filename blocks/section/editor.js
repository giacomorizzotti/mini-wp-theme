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
            var extraClasses  = attributes.extraClasses  || '';
            var menuItemName  = attributes.menuItemName  || '';
            var isPageMenu    = attributes.isPageMenu    || false;
            var size          = attributes.size          || '';
            var spaceTop      = attributes.spaceTop      || false;
            var spaceBot      = attributes.spaceBot      || false;

            var className = ['mini-section-wrap'];
            if (isPageMenu) className.push('page-menu');
            if (extraClasses) className.push(extraClasses);

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
                        el(TextControl, {
                            label: __('Extra classes', 'mini'),
                            help: __('Additional CSS classes (e.g. fw-bg, color-bg).', 'mini'),
                            value: extraClasses,
                            onChange: function (val) { setAttributes({ extraClasses: val }); }
                        }),
                        el(SelectControl, {
                            label: __('Inner size', 'mini'),
                            help: __('Wraps content in a .container inside the section.', 'mini'),
                            value: size,
                            options: [
                                { label: __('None (no container)',  'mini'), value: ''     },
                                { label: __('Default container',    'mini'), value: 'default' },
                                { label: __('Full width (fw)',      'mini'), value: 'fw'   },
                                { label: __('Wide',                 'mini'), value: 'wide' },
                                { label: __('Thin',                 'mini'), value: 'thin' },
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
