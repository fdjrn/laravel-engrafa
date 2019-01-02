<template>
    <li class="treeview" data-toggle="control-sidebar">
        <a href="#control-sidebar-bookmark-tab" data-toggle="tab">
            <i class="fa fa-bookmark"></i>
            <span>Bookmark</span>
            <span class="pull-right-container">
				<small class="label pull-right bg-green"> {{ this.totalBookmark }}</small>
            </span>
        </a>
    </li>
</template>

<script>
    export default {
        props: {
            user: {
                type: Object,
                required: true
            }
        },
        data() {
            return {
                totalBookmark: 0
            }
        },
        mounted() {

            Echo.private('bookmark.' + this.user.id)
                .listen('NewBookmarks', (e) => {
                    this.totalBookmark++;
                });

            axios.get('/bookmarks/' + this.user.id)
                .then((response) => {
                    this.totalBookmark = response.data.length;
                });
        },
        methods: {
            getUnreadNotification() {
                axios.get(`/notification/getUnreadNotification`)
                    .then((response) => {
                        this.unread = response.data
                    });
            }
        }
    }
</script>