let user = window.App.user;

let authorizations = {
    owns(model, props = 'user_id') {
        return model[props] == user.id
    },

    isAdmin() {
        return ['JohnDoe', 'JaneDoe'].includes(user.name)
    }
}


module.exports = authorizations;