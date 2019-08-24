
Vue.filter('globalMediaPath', value=>{
    if(!value){return null}
    return '/storage/' + value.path + '/' + value.original_file_name
})

Vue.filter('capitalize', value=>{
    return _.startCase(_.camelCase(value))
})

Vue.filter('linkify', value=>{
    return value.replace(/\s+/g, '-').toLowerCase()
})

Vue.filter('filterTitle', value=>{
    if(value){
        let withFor = value.replace(/[-_.]/g,' ')
        let whereIsForIndex
        if(withFor.includes('wanted for')){
            whereIsForIndex = withFor.indexOf('wanted')
        }else if(withFor.includes('available for')){
            whereIsForIndex = withFor.indexOf('available')
        }
        return withFor.substring(0,whereIsForIndex)
    }

})
Vue.filter('filterDetailsPageTitle', value=>{
    if(value){
        let withFor = value.replace(/[-_.]/g,' ')
        return withFor
    }

})
Vue.filter('titlify', value=>{
    if(value){
        if(value.length<40){
            return value
        }else{
            return value.substring(0,40)+' ...'
        }
    }

})


Vue.filter('namify', value=>{
    if(value){
        if(value.length<10){
            return value
        }else{
            return value.substring(0,10)+' ...'
        }
    }

})

Vue.filter('count', arr=>{
    return _.count(arr)
})

Vue.filter('imagePathForStyle', value=>{
    if(value){
        let urlParam =  '/storage/'+value.path+'/'+value.original_file_name
        let attributeValue = 'url("'+ urlParam + '")'
        return {'background-image': attributeValue}
    }

})

Vue.filter('fullName', value=>{
    return `${value.first_name} ${value.last_name}`
})

Vue.filter('removeUnderScore', (value) => {
    if(!value) return ''
    return value.replace('_', ' ')
})

Vue.filter('removeHyphen', (value) => {
    if(!value) return ''
    return value.replace(/-/g, ' ');
})

Vue.filter('customBirthDay', (value) => {
    if(!value) return ''
    return 'Please enter from 1 to 31';
})
Vue.filter('customBirthMonth', (value) => {
    if(!value) return ''
    return 'Please enter from 1 to 12';
})

Vue.filter('customEmailMessage', (value) => {
    if(!value) return ''
    return 'Please enter a valid email address';
})

Vue.filter('filterFeaturedImageFromArray', arr=>{
    for(let i=0;i<arr.length;i++){
        if(arr[i].is_featured==1){
            if(arr[i]){
                return '/storage/' + arr[i].path + '/' + arr[i].original_file_name
            }
        }
    }
    if(arr[0]){
        return '/storage/' + arr[0].path + '/' + arr[0].original_file_name
    }
})
