<template>
    <ckeditor :editor="editor" v-model="editorData" :config="editorConfig" tag-name="textarea" name="text"></ckeditor>
</template>

<script>
import ClassicEditor from '@ckeditor/ckeditor5-build-classic'
export default {
    name: "TextArticleComponent",
    data: function () {
        return {
            editor: ClassicEditor,
            editorData: '<p>Content of the editor.</p>',
            editorConfig: {
                // The configuration of the editor.
            }
        }
    }
}
</script>

<style scoped>

</style>
