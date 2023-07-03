<template>
    <div>
        <img :src="image" alt="image">
        <p class="showTextGuest" :class="{'active': isActive}">{{ fullname }}</p>
    </div>
    <!-- <div id="hcm"> -->
        <!-- <div class="popup__welcome" :class="{'active' : isActive}">
            <img :src="rootUrl('/images/checkin.png')" alt="welcome">
            <div class="popup__welcome-detail">
                <p>Detail</p>
                <p>Name: {{ fullname }}</p>
                <p>studentID: {{ mssv ?? "Không có" }}</p>
                <p>Event: Talkshow "AI RESEARCH FOR</p>
                <p>EDUCATION TECHNOLOGY"</p>
            </div>
        </div> -->
        <!-- <div class="standee" :style="'background-image: url(' + rootUrl('/images/background.jpg') + ')'">
            <div class="standee__header">
                <img :src="rootUrl('/images/logo-1.png')"  alt="logo">
                <img :src="rootUrl('/images/logo-2.png')" alt="logo">
            </div>
            <div class="standee__welcome">
                <p>Welcome</p>
                <div class="standee__welcome-ribon">
                    <p :class="{'active' : textActive}">{{ fullname }}</p>
                    <img :src="rootUrl('/images/ribon.png')" alt="ribon">
                </div>
            </div>
            <div class="standee__content">
                <div class="standee__content-head">Talkshow</div>
                <div class="standee__content-title">
                    <p>AI research</p>
                    <p>for educational technology</p>
                </div>
                <div class="standee__content-desc">
                    <div class="left">
                        <img :src="rootUrl('/images/avatar.png')" alt="avatar">
                    </div>
                    <p>(29th May,2023)</p>
                </div>
            </div>
        </div> -->
    <!-- </div> -->
</template>

<script>
    import { mapGetters } from 'vuex';
    import { database } from '../firebase.js';
    import { ref, onValue, remove, get } from "firebase/database";
    export default {
        name: "loader-component",
        props: {
            image: String
        },
        mounted() {
            this.getGuest();
        },
        computed: {
            ...mapGetters({
                data: "data"
            })
        },
        data() {
            return {
                fullname: "Khách mời",
                mssv: null,
                isActive: true,
                timeoutId: null,
                // textActive: false,
                // timeHidePopup: 2000,
                timeShowText: 400
            }
        },
        methods: {
            getGuest(){
                onValue(ref(database, 'guests-' + campusId + '-' + eventId), (data) => {
                    data.forEach(item => {
                        if (item.val()) {
                            let guest = item.val();
                            this.mssv = guest.mssv
                            this.showText(guest.fullname)
                            remove(item.ref)
                        }
                    })
                })
            },
            rootUrl(url) {
                return window.location.origin + url;
            },
            // Yêu cầu chế độ fullscreen cho phần tử document
            showText(fullname) {
                this.isActive = false;
                this.fullname = fullname;
                setTimeout(() => {
                    this.isActive = true;
                }, this.timeShowText)
            },
            // showPopup() {
            //     this.isActive = true;
            //     if (this.timeoutId) {
            //         clearTimeout(this.timeoutId);
            //     }
            //     this.timeoutId = setTimeout(() => {
            //         this.isActive = false;
            //     }, this.timeHidePopup);
            // }
        },
    }
</script>
