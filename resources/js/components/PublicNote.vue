<template>

    <div class="mrck-container" v-if="note">
        <div class="lg:grid lg:grid-cols-12 lg:gap-x-5 mt-5 lg:py-0 lg:px-10">
            <div class="lg:col-span-3 py-6 px-2 sm:px-6 lg:py-0 lg:px-0"></div>
            <div class="lg:col-span-9 m:px-6 lg:px-0">
                <section  id="mrck-roots-wrapper">
                    <div class="page bg-white border-2 border-solid border-grey shadow-md mb-5" v-for="(roots, page) in note.content" :key="`page-${page}`" >
                        <div v-if="roots.cue || roots.note || roots.summary">
                            <div class="grid grid-cols-3 cue-note-section ck h-[25cm]">
                                <div :id="'cue-' + (page+1)" class="root cue border-r-dotted ck-content ck-editor__editable_inline ck ck-editor__editable ck-rounded-corners" v-html="roots.cue">
                                </div>

                                <div :id="'note-' + (page+1)" class="col-span-2 root note ck-content ck-editor__editable_inline ck ck-editor__editable ck-rounded-corners" v-html="roots.note">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 py-3">
                                <div class="summary-section">
                                    <div :id="'summary-' + (page+1)"  class="root summary h-[5cm] ck-content ck-editor__editable_inline ck ck-editor__editable ck-rounded-corners" v-html="roots.summary"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</template>

<script>
export default {

    props : [
        'note'
    ],

    mounted() {

        if (this.note) {
            this.$mitt.emit('note-mounted', this.note);
        }
    },

}
</script>

<style>
    .cue {
        border-right: 2px dotted black !important;
    }

    .summary {
        border-top: 2px dotted black !important;
    }

    .note p>img {
        align-items: flex-start;
        display: inline-flex;
        max-width: 100%;
        outline-color: transparent;
        outline-style: solid;
        outline-width: var(--ck-widget-outline-thickness);
        transition: outline-color var(--ck-widget-handler-animation-duration) var(--ck-widget-handler-animation-curve);
        margin-top: var(--ck-spacing-large);
        position: relative;
    }
</style>
