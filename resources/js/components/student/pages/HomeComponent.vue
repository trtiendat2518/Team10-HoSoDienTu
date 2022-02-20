<template>
    <div class="container">
        <!-- SECTION BANNER -->
        <div class="section-banner">
            <img class="section-banner-icon" :src="`../public/student/img/banner/newsfeed-icon.png`" alt="newsfeed-icon" />
            <p class="section-banner-title">Trang sinh viên</p>
        </div>
        <!-- /SECTION BANNER -->

        <!-- GRID -->
        <div class="grid quick-post">
            <!-- QUICK POST HEADER -->
            <div class="quick-post-header">
                <!-- OPTION ITEMS -->
                <div class="option-items">
                    <!-- OPTION ITEM -->
                    <div class="option-item active">
                        <!-- OPTION ITEM ICON -->
                        <svg class="option-item-icon icon-status">
                            <use xlink:href="#svg-status"></use>
                        </svg>
                        <!-- /OPTION ITEM ICON -->

                        <!-- OPTION ITEM TITLE -->
                        <p class="option-item-title">Status</p>
                        <!-- /OPTION ITEM TITLE -->
                    </div>
                    <!-- /OPTION ITEM -->

                    <!-- OPTION ITEM -->
                    <div class="option-item">
                        <!-- OPTION ITEM ICON -->
                        <svg class="option-item-icon icon-blog-posts">
                            <use xlink:href="#svg-blog-posts"></use>
                        </svg>
                        <!-- /OPTION ITEM ICON -->

                        <!-- OPTION ITEM TITLE -->
                        <p class="option-item-title">Blog Post</p>
                        <!-- /OPTION ITEM TITLE -->
                    </div>
                    <!-- /OPTION ITEM -->

                    <!-- OPTION ITEM -->
                    <div class="option-item">
                        <!-- OPTION ITEM ICON -->
                        <svg class="option-item-icon icon-poll">
                            <use xlink:href="#svg-poll"></use>
                        </svg>
                        <!-- /OPTION ITEM ICON -->

                        <!-- OPTION ITEM TITLE -->
                        <p class="option-item-title">Poll</p>
                        <!-- /OPTION ITEM TITLE -->
                    </div>
                    <!-- /OPTION ITEM -->
                </div>
                <!-- /OPTION ITEMS -->
            </div>
            <!-- /QUICK POST HEADER -->

            <!-- QUICK POST BODY -->
            <div class="quick-post-body">
                <!-- FORM -->
                <form class="form">
                    <!-- FORM ROW -->
                    <div class="form-row">
                        <!-- FORM ITEM -->
                        <div class="form-item">
                            <!-- FORM TEXTAREA -->
                            <div class="form-textarea">
                                <textarea
                                    id="quick-post-text"
                                    name="quick-post-text"
                                    placeholder="Hi Marina! Share your post here..."
                                ></textarea>
                                <!-- FORM TEXTAREA LIMIT TEXT -->
                                <p class="form-textarea-limit-text">998/1000</p>
                                <!-- /FORM TEXTAREA LIMIT TEXT -->
                            </div>
                            <!-- /FORM TEXTAREA -->
                        </div>
                        <!-- /FORM ITEM -->
                    </div>
                    <!-- /FORM ROW -->
                </form>
                <!-- /FORM -->
            </div>
            <!-- /QUICK POST BODY -->

            <!-- QUICK POST FOOTER -->
            <div class="quick-post-footer">
                <!-- QUICK POST FOOTER ACTIONS -->
                <div class="quick-post-footer-actions">
                    <!-- QUICK POST FOOTER ACTION -->
                    <div class="quick-post-footer-action text-tooltip-tft-medium" data-title="Insert Photo">
                        <!-- QUICK POST FOOTER ACTION ICON -->
                        <svg class="quick-post-footer-action-icon icon-camera">
                            <use xlink:href="#svg-camera"></use>
                        </svg>
                        <!-- /QUICK POST FOOTER ACTION ICON -->
                    </div>
                    <!-- /QUICK POST FOOTER ACTION -->

                    <!-- QUICK POST FOOTER ACTION -->
                    <div class="quick-post-footer-action text-tooltip-tft-medium" data-title="Insert GIF">
                        <!-- QUICK POST FOOTER ACTION ICON -->
                        <svg class="quick-post-footer-action-icon icon-gif">
                            <use xlink:href="#svg-gif"></use>
                        </svg>
                        <!-- /QUICK POST FOOTER ACTION ICON -->
                    </div>
                    <!-- /QUICK POST FOOTER ACTION -->

                    <!-- QUICK POST FOOTER ACTION -->
                    <div class="quick-post-footer-action text-tooltip-tft-medium" data-title="Insert Tag">
                        <!-- QUICK POST FOOTER ACTION ICON -->
                        <svg class="quick-post-footer-action-icon icon-tags">
                            <use xlink:href="#svg-tags"></use>
                        </svg>
                        <!-- /QUICK POST FOOTER ACTION ICON -->
                    </div>
                    <!-- /QUICK POST FOOTER ACTION -->
                </div>
                <!-- /QUICK POST FOOTER ACTIONS -->

                <!-- QUICK POST FOOTER ACTIONS -->
                <div class="quick-post-footer-actions">
                    <!-- BUTTON -->
                    <p class="button small void">Discard</p>
                    <!-- /BUTTON -->

                    <!-- BUTTON -->
                    <p class="button small secondary">Post</p>
                    <!-- /BUTTON -->
                </div>
                <!-- /QUICK POST FOOTER ACTIONS -->
            </div>
            <!-- /QUICK POST FOOTER -->
        </div>
        <!-- /GRID -->
    </div>
</template>

<script>
export default {}
</script>

<style></style>
