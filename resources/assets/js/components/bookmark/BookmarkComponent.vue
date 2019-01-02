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
            @click="gotoBookmarkedFiles(bookmark)">
            <li>
                <a href="javascript:void(0)" class="text-with">
                    <i class="menu-icon fa fa-folder-o bg-red" v-if="bookmark.is_file == 0"></i>
                    <i class="menu-icon fa fa-file-text bg-red" v-else></i>
                    <div class="menu-info">
                        <h4 class="control-sidebar-subheading">{{ bookmark.name }}</h4>
                        <p>{{ bookmark.descr }}</p>
                        <small>{{ bookmark.created_at}}</small>
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
                selectedFiles: null,
                newBookmark: {
                    type: Object
                }
            }
        },
        mounted() {
            Echo.private('bookmark.' + this.user.id)
                .listen('NewBookmarks', (e) => {
                    this.newUserBookmark(e);
                });

            axios.get('/bookmarks/' + this.user.id)
                .then((response) => {
                    this.bookmarks = response.data;
                });
        },
        methods: {
            newUserBookmark(data) {
                var bm = {
                    created_at: data.bookmark.created_at,
                    descr: data.file.description,
                    file: data.bookmark.file,
                    id: data.bookmark.id,
                    is_file: data.file.is_file,
                    name: data.file.name
                };

                this.bookmarks.push(bm);
            },

            gotoBookmarkedFiles(bookmark) {
                this.selectedFiles = bookmark;
                if (this.selectedFiles.is_file === 1) {
                    return window.location.href = '/index/detail/' + this.selectedFiles.file;
                } else {
                    return window.location.href = '/index?folder_id=' + this.selectedFiles.file;
                }
            }
        }
    }
</script>

<style lang="scss" scoped>
    .menu-info {
        p {
            font-weight: normal;
            font-style: italic;
            color: whitesmoke;
        }

        small {
            font-weight: normal;
            /*color: whitesmoke;*/
        }
    }
</style>