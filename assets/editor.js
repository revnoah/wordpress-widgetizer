import { render } from '@wordpress/element';
import { EditorProvider, BlockEditorProvider } from '@wordpress/block-editor';
import { useState } from '@wordpress/element';
import { useSelect } from '@wordpress/data';

const WidgetizerEditor = () => {
    const savedContent = useSelect((select) =>
        select('core/editor').getEditedPostContent() || ''
    );

    const [blocks, setBlocks] = useState(
        wp.blocks.parse(savedContent || document.getElementById('widgetizer_dynamic_content').value)
    );

    return (
        <EditorProvider
            settings={{}}
            value={blocks}
            onChange={(updatedBlocks) => {
                setBlocks(updatedBlocks);
                document.getElementById('widgetizer_dynamic_content').value = wp.blocks.serialize(updatedBlocks);
            }}
        >
            <BlockEditorProvider value={blocks} onChange={setBlocks} />
        </EditorProvider>
    );
};

document.addEventListener('DOMContentLoaded', () => {
    const target = document.getElementById('widgetizer-dynamic-content-editor');
    if (target) {
        render(<WidgetizerEditor />, target);
    }
});
