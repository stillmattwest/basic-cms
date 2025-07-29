<x-app-layout>
    <x-forms.form>
        <x-forms.inputs.wysiwyg-editor 
            name="content" 
            label="Post Content" 
            placeholder="Write your content..." 
            toolbar="full"
            height="300px" 
            required 
            :error="$errors->first('content')"
        >
        </x-forms.inputs.wysiwyg-editor>
    </x-forms.form>
</x-app-layout>
