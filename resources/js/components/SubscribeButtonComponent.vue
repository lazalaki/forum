<template>
    <div>
        <button :class="classes"  @click="subscribe">{{ this.active ? 'Unsubscribe' : 'Subscribe'}}</button>
    </div>
</template>

<script>
    export default {
        props: ['active'],

        computed: {
            classes() {
                return ['btn', this.active ? 'btn-primary' : 'btn-secondary']
            }
        },

        methods: {
            subscribe() {

                axios[
                    (this.active ? 'delete' : 'post')
                ](location.pathname + '/subscriptions');

                this.active = ! this.active

            }
        }
    }
</script>
