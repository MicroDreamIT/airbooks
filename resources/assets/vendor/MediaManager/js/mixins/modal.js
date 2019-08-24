import MediaModal from './media-modal.vue'

export default {
    components: {MediaModal},
    data() {
        return {
            inputName: ''
        }
    },
    methods: {
        toggleModalFor(name) {
            this.inputName = name
            EventHub.fire('modal-details')
        },
        hideInputModal() {
            this.inputName = ''
            EventHub.fire('modal-hide')
        }
    }
}
