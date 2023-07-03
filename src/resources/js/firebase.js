import { initializeApp } from "firebase/app";
import { getDatabase } from "firebase/database";
// TODO: Add SDKs for Firebase products that you want to use
// https://firebase.google.com/docs/web/setup#available-libraries

// Your web app's Firebase configuration
// For Firebase JS SDK v7.20.0 and later, measurementId is optional
const firebaseConfig = {
    apiKey: "AIzaSyDx52ze9FhUSxI2PumVGqqQVcSS0Z-Arwk",
    authDomain: "fpt-event-7d548.firebaseapp.com",
    databaseURL: "https://fpt-event-7d548-default-rtdb.firebaseio.com",
    projectId: "fpt-event-7d548",
    storageBucket: "fpt-event-7d548.appspot.com",
    messagingSenderId: "232407766887",
    appId: "1:232407766887:web:2d5106c1606670bc2501c2",
    measurementId: "G-ENVZFFTSZT"
};

// Initialize Firebase
const firebase = initializeApp(firebaseConfig);
export const database = getDatabase(firebase);
