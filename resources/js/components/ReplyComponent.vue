<template>
    <div>
        <div :id="'reply-' + id" class="card mb-3">
            <div class="card-header" :class="isBest ? 'bg-success' : 'bg-default'">
                <div class="level">
                    <h5 class="flex">    
                        <a :href="'/profiles' + data.owner.name"
                            v-text="data.owner.name">
                        </a>
                        said <span v-text="ago"></span>
                    </h5>

                    <div v-if="signedIn">
                        <favorite-component :reply="data"></favorite-component>
                    </div>
                </div>
            </div>         
                
            <div class="card-body">
                <div v-if="editing">
                    <form @submit="update">
                        <div class="form-group">
                            <textarea class="form-control" v-model="body" required></textarea>
                        </div>
                        <button class="btn btn-sm btn-outline-secondary">Update</button>
                        <button class="btn btn-sm btn-link" @click="editing = false" type="button">Cancel</button>
                    </form>
                </div>
                <div v-else v-html="body"></div>
                
            </div>
                <div class="card-footer level">
                    <div v-if="canUpdate">
                        <button class="btn btn-outline-secondary btn-sm mr-2" @click="editing = true">Edit</button>
                        <button class="btn btn-outline-danger btn-sm mr-2" @click="destroy">Delete</button>
                    </div>
                    <button class="btn btn-outline-secondary btn-sm ml-auto" @click="markBestReply" v-show="!isBest">Best Reply?</button>
                </div>
        </div>
    </div>
</template>

<script>
import FavoriteComponent from './FavoriteComponent.vue';
import moment from 'moment';

    export default {
        props: ['data'],

        components: {
            FavoriteComponent
        },

        data() {
            return {
                editing: false,
                id: this.data.id,
                body: this.data.body,
                isBest: false
            }
        },

        computed: {
            ago() {
                return moment(this.data.created_at).fromNow() + '...'
            },

            signedIn() {
                return window.App.signedIn
            },

            canUpdate() {
                return this.authorize(user => this.data.user_id == user.id)
            }
        },

        methods: {
            update() {
                axios.patch('/replies/' + this.data.id, {
                    body: this.body
                })
                .catch(error => {
                    flash(error.response.data, 'danger')
                });

                this.editing = false

                flash('Updated!')
            },

            destroy() {
                axios.delete('/replies/' + this.data.id)

                this.$emit('deleted', this.data.id);

            },

            markBestReply() {
                this.isBest = true;
            }
        }
    }
</script>

