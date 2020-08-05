<template>
    <div>
        <button type="submit" :class="classes" @click="toggle">
            <i class="glyphicon glyphicon-heart">Favorited</i>
            <span v-text="favoritesCount"></span>
        </button>
    </div>
</template>

<script>
    export default {
        props: ['reply'],

        data() {
            return {
                favoritesCount: this.reply.favoritesCount,
                isFavorited: this.reply.isFavorited
            }
        },

        computed: {
            classes() {
                return ['btn', this.isFavorited ? 'btn-primary' : 'btn-secondary']
            },

            endpoint() {
                return '/replies/' + this.reply.id + '/favorites'
            }
        },

        methods: {
            toggle() {

                this.isFavorited ? this.destroy() : this.create()
            },

            create() {
                axios.post(this.endpoint)

                this.isFavorited = true
                this.favoritesCount++
            },

            destroy() {
                axios.delete(this.endpoint)

                this.isFavorited = false
                this.favoritesCount--
            }
        }
    }
</script>

<style lang="scss" scoped>

</style>