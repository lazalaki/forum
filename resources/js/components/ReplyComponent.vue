<template>
    <div>

    </div>
</template>

<script>
import FavoriteComponent from './FavoriteComponent.vue';

    export default {
        props: ['attributes'],

        components: {
            FavoriteComponent
        },

        data() {
            return {
                editing: false,
                body: this.attributes.body
            }
        },

        methods: {
            update() {
                axios.patch('/replies/' + this.attributes.id, {
                    body: this.body
                });

                this.editing = false

                flash('Updated!')
            },

            destroy() {
                axios.delete('/replies/' + this.attributes.id)

                $(this.$el).fadeOut(300, () => {
                    flash('Deleted!')
                })
            }
        }
    }
</script>

<style lang="scss" scoped>

</style>