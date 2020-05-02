<template>
    <b-button
        type="button"
        variant="link"
        @click="changeVideo()"
    >
        <i class="fas fa-play-circle"></i>
        {{ nombreVideo }}
    </b-button>
</template>
<script>
    export default {
        props: {
            codigo:{
                default: null,
            },
            nombreVideo:{
                default: null,
            }
        },
        methods: {
            changeVideo() {
                $('#embedVideo').attr('src', 'https://www.youtube.com/embed/'+this.codigo);
            }
        },
    };
</script>