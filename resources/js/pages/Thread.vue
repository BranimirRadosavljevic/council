<script>
import Replies from '../components/Replies';
import SubscribeButton from '../components/SubscribeButton';

export default {
    props: ['thread'],

    components: { Replies, SubscribeButton },

    data(){
        return {
            repliesCount: this.thread.replies_count,
            locked: this.thread.locked,
            pinned: this.thread.pinned,
            editing: false,
            title: this.thread.title,
            body: this.thread.body,
            form: {}
        };
    },

    created() {
        this.resetForm();
    },

    methods: {
        toggleLock(){
            let uri = `/locked-threads/${this.thread.slug}`;
            axios[this.locked ? 'delete' : 'post'](uri); 
            this.locked = !this.locked;
        }, 

        togglePin(){
            let uri = `/pinned-threads/${this.thread.slug}`;
            axios[this.pinned ? 'delete' : 'post'](uri); 
            this.pinned = !this.pinned;
        },

        update(){
            let uri = `/threads/${this.thread.channel.slug}/${this.thread.slug}`
            axios.patch(uri, this.form).then(() => {
                this.editing = false;
                this.title = this.form.title;
                this.body = this.form.body;
                flash('Your thread has been updated.');
            });
        },

        resetForm(){
            this.form = {
                title: this.thread.title,
                body: this.thread.body
            };

            this.editing = false;
        },

        classes(target) {
            return [
                'btn',
                target ? 'btn-primary' : 'btn-outline-secondary'
            ];
        }
    },
}
</script>