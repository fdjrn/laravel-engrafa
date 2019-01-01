<template>
    <div class="tab-pane" id="control-sidebar-bookmark-tab">
        <h3 class="control-sidebar-heading">
            <i class="fa fa-bookmark fa-fw"></i>
            <span>&nbsp;</span>
            <span>Bookmark</span>
            <!--<a href="#" >-->
            <span class="pull-right">
                    <i class="label bg-yellow"> {{ this.bookmarks.length }}</i>
                    <a href="#">
                        <i class="fa fa-remove fa-fw"></i>
                    </a>
                </span>
            <!--</a>-->
        </h3>

        <!-- search form -->
        <!--<form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
                    <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i
                            class="fa fa-search"></i>
                    </button>
                  </span>
            </div>
        </form>-->

        <ul class="control-sidebar-menu" v-for="bookmark in bookmarks" :key="bookmark.id"
            @click="gotoBookmarkedFiles(bookmark)" @>
            <li>
                <a href="javascript:void(0)" class="text-with">
                    <i class="menu-icon fa fa-folder-o bg-red" v-if="bookmark.is_file == 0"></i>
                    <i class="menu-icon fa fa-file-text bg-red" v-else></i>
                    <div class="menu-info">
                        <h4 class="control-sidebar-subheading">
                            {{ bookmark.name }}
                            <div class="pull-right">
                                <span>{{ bookmark.created_at}}</span>
                            </div>
                        </h4>
                        <small>{{ bookmark.descr }}</small>
                    </div>
                </a>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        name: "BookmarkComponent",
        props: {
            user: {
                type: Object,
                required: true
            },

        },
        data() {
            return {
                bookmarks: [],
                selectedFiles: null
            }
        },
        mounted() {
            Echo.private('bookmark.' + this.user.id )
                .listen('NewBookmarks', (e) => {

                    console.log(e);

                    //this.newUserBookmark(e);
                });

            axios.get('/bookmarks/' + this.user.id)
                .then((response) => {
                    this.bookmarks = response.data;
                });
        },
        methods: {
            newUserBookmark(bookmark) {
                let bm = {
                    //created_at: moment(bookmark.created_at, "YYYYMMDD").fromNow(),
                    created_at: bookmark.created_at,
                    descr: bookmark.descr,
                    file: bookmark.file,
                    id:bookmark.id,
                    is_file: bookmark.is_file,
                    name:bookmark.name
                }
                this.bookmarks.push(bm);
            },

            gotoBookmarkedFiles(bookmark){
                this.selectedFiles = bookmark;
                if (this.selectedFiles.is_file == 1) {
                    window.location.href = '/index/detail/' + this.selectedFiles.file;
                } else {

                    let csrf_token = $('meta[name="csrf-token"]').attr('content');
                    axios.post('/index', {
                        'folder_id': this.selectedFiles.file,
                        '_token': csrf_token,
                        '_method': 'POST'
                    }).then(response => {
                        if (response) {
                            self.$router.push('/index');
                        }
                    }).catch(e => {
                            this.errors.push(e)
                    });

                }
            }
        }
    }
</script>

<style lang="scss" scoped>
    .menu-info {
        p, small {
            font-weight: normal;
            font-style: italic;
            color: whitesmoke;
        }
    }
</style>