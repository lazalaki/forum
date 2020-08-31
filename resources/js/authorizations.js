let user = window.App.user;

let authorizations = {
    owns(model, props = 'user_id') {
        return model[props] == user.id
    }
}


module.exports = authorizations;