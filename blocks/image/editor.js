(function (blocks, element, blockEditor, components, i18n) {
    var el              = element.createElement;
    var Fragment        = element.Fragment;
    var useBlockProps   = blockEditor.useBlockProps;
    var InspectorControls = blockEditor.InspectorControls;
    var MediaUpload     = blockEditor.MediaUpload;
    var MediaUploadCheck = blockEditor.MediaUploadCheck;
    var PanelBody       = components.PanelBody;
    var Button          = components.Button;
    var TextControl     = components.TextControl;
    var ToggleControl   = components.ToggleControl;
    var __              = i18n.__;

    blocks.registerBlockType('mini/image', {
        edit: function (props) {
            var attrs         = props.attributes;
            var setAttributes = props.setAttributes;
            var url           = attrs.url           || '';
            var id            = attrs.id            || 0;
            var alt           = attrs.alt           || '';
            var linkUrl       = attrs.linkUrl       || '';
            var openInNewTab  = attrs.openInNewTab  || false;
            var width         = attrs.width         || '';
            var height        = attrs.height        || '';

            var blockProps = useBlockProps({
                style: { display: 'block' }
            });

            return el(
                Fragment,
                null,
                el(
                    InspectorControls,
                    null,
                    el(
                        PanelBody,
                        { title: __('Image settings', 'mini'), initialOpen: true },
                        el(TextControl, {
                            label: __('Alt text', 'mini'),
                            value: alt,
                            onChange: function (val) { setAttributes({ alt: val }); }
                        }),
                        el(TextControl, {
                            label: __('Width', 'mini'),
                            help: __('e.g. 100%, 300px, auto', 'mini'),
                            value: width,
                            onChange: function (val) { setAttributes({ width: val }); }
                        }),
                        el(TextControl, {
                            label: __('Height', 'mini'),
                            help: __('e.g. 200px, auto', 'mini'),
                            value: height,
                            onChange: function (val) { setAttributes({ height: val }); }
                        }),
                        el(TextControl, {
                            label: __('Link URL', 'mini'),
                            help: __('Wraps the image in an <a> tag.', 'mini'),
                            value: linkUrl,
                            type: 'url',
                            onChange: function (val) { setAttributes({ linkUrl: val }); }
                        }),
                        linkUrl && el(ToggleControl, {
                            label: __('Open link in new tab', 'mini'),
                            checked: openInNewTab,
                            onChange: function (val) { setAttributes({ openInNewTab: val }); }
                        })
                    )
                ),
                el(
                    'div',
                    blockProps,
                    el(
                        MediaUploadCheck,
                        null,
                        el(MediaUpload, {
                            onSelect: function (media) {
                                setAttributes({
                                    url: media.url,
                                    id:  media.id,
                                    alt: alt || media.alt || '',
                                });
                            },
                            allowedTypes: ['image'],
                            value: id,
                            render: function (obj) {
                                return url
                                    ? el(
                                        'div',
                                        { style: { position: 'relative', display: 'inline-block' } },
                                        el('img', {
                                            src:   url,
                                            alt:   alt,
                                            style: { display: 'block', maxWidth: '100%', width: width || undefined, height: height || undefined },
                                            className: 'img',
                                        }),
                                        el(
                                            Button,
                                            {
                                                onClick: obj.open,
                                                style: {
                                                    position: 'absolute', top: '8px', left: '8px',
                                                    background: 'rgba(0,0,0,0.6)', color: '#fff',
                                                    borderRadius: '3px', padding: '4px 10px',
                                                    fontSize: '12px', cursor: 'pointer',
                                                },
                                            },
                                            __('Replace', 'mini')
                                        )
                                    )
                                    : el(
                                        'div',
                                        {
                                            style: {
                                                border: '2px dashed #aaa', borderRadius: '4px',
                                                padding: '24px', textAlign: 'center',
                                                background: '#fafafa', cursor: 'pointer',
                                            },
                                            onClick: obj.open,
                                        },
                                        el('span', {
                                            style: { fontSize: '13px', color: '#888' }
                                        }, __('Click to choose an image', 'mini'))
                                    );
                            }
                        })
                    )
                )
            );
        },

        save: function () { return null; }
    });

}(window.wp.blocks, window.wp.element, window.wp.blockEditor, window.wp.components, window.wp.i18n));
