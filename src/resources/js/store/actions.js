import Vue from 'vue'
import { database } from '../firebase.js';
import { ref, set, child, get, onValue } from "firebase/database";

let loader = null;

function addLoader(){
    loader = Vue.prototype.$loading({
        lock: true,
        text: 'Loading',
        spinner: 'el-icon-loading',
        background: 'rgba(0, 0, 0, 0.7)'
    })
}

function removeLoader(){
    loader.close();
}

function notify(title,content){
    Vue.prototype.$notify({
        title: title == 200 ? 'Thành công' : 'Thất bại',
        dangerouslyUseHTMLString: true,
        message: content
    });
}

// export const getGuest = ({commit}, payload) => {
//     addLoader()

//     axios.get('api/chatroom',payload).then(res => {

//         if(res.status == 200){
//             console.log(res.data);
//             return commit("setData",res.data);
//         }

//     })
//     removeLoader()

// }
