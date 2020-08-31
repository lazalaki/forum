<template>
    <div>
        <div v-if="signedIn">
            <div class="form-group">
                <textarea name="body" 
                        id="body" 
                        class="form-control" 
                        rows="5" 
                        placeholder="Have something to say?"
                        required
                        v-model="body"></textarea>
            </div>
            <button type="submit" 
                    class="btn btn-primary"
                    @click="addReply">Post</button>
        </div>
            <p class="text-center" v-else>
                Please <a href="/login">Log In</a> to participate in this discussion
            </p>
    </div>
</template>

<script>
import 'jquery.caret';
import 'at.js';
    export default {


        data() {
            return {
                body: '',
            }
        },

        mounted() {
            $('#body').atwho({
                at: "@",
                delay: 750,
                callbacks: {
                    remoteFilter: function(query, callback) {
                        $.getJSON("/api/users", {name: query}, function(usernames) {//autocomplete mentioning @JaneDoe
                            callback(usernames)
                        });
                    }
                }
            });
        },

        methods: {
            addReply() {
                axios.post(location.pathname + '/replies', { body: this.body })
                    .then(response => {
                        this.body = ''
                        flash('Your reply has been posted')
                        this.$emit('created', response.data)
                    })
                    .catch(error => {
                        flash(error.response.data, 'danger')
                    })
            }
        }
    }
</script>

<style lang="scss" scoped>

</style>