<template>
    <div>
        <input type="file" accept="image/*" @change="onChange">
        <button type="submit">Add Avatar</button>
    </div>
</template>

<script>
    export default {
        methods: {
            onChange(e) {
                if (! e.target.files.length) return;
                let file = e.target.files[0];
                let reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onload = e => {
                    let src = e.target.result;
                    this.$emit('loaded', { src, file });
                };
            }
        }
    }
</script>

<style lang="scss" scoped>

</style>