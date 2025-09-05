// useVoiceRecorder.js
import {computed, ref} from 'vue';
import { debounce } from 'lodash';
import {useAlert} from "@/composable/useAlert";
import {useSocketService} from "@/composable/useSocket";
import RepositoryFactory from "@/repository/RepositoryFactory";

export function useVoiceRecorder(socket,destinationMessage, {emits}) {
    const { serverSendMessageEmitter } = useSocketService();
    const isRecording = ref(false);
    const mediaRecorder = ref(null);
    const audioChunks = ref([]);
    const timer = ref(0);
    const interval = ref(null);
    const { error } = useAlert();
    const to = computed(()=> destinationMessage);
    const startRecording = async () => {
        try {
            if (!isRecording.value) {
                const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
                mediaRecorder.value = new MediaRecorder(stream);
                isRecording.value = true;
                // audioChunks.value = [];
                timer.value = 0;

                interval.value = setInterval(() => {
                    timer.value++;
                }, 1000);

                mediaRecorder.value.ondataavailable = (event) => {
                    audioChunks.value.push(event.data);
                };

                mediaRecorder.value.start();
            }
        }catch (e) {
            console.error('Error accessing microphone:', error);
            error('دسترسی به میکروفون امکان پذیر نیست.لطفا دسترسی خود را بررسی نمایید.');
        }
    };

    const stopRecording = () => {
        if (isRecording.value) {
            mediaRecorder.value.stop();
            mediaRecorder.value.onstop = debounce(() => {
                const audioBlob = new Blob(audioChunks.value, { type: 'audio/webm' });
                sendVoiceMessage(audioBlob);
                audioChunks.value = [];
                isRecording.value = false;
                clearInterval(interval.value);
            }, 300); // Optional debouncing to handle quick successive stops
        }
    };

    const uploadVoice = async (voice)=> {
        const ChatRepository = RepositoryFactory.get('Chat');
        const fileName = Date.now() + '.mp3'; // Or use any other unique ID for file naming
        let fileObject = new File([voice], fileName, {
            type: 'audio/webm',
        });

        const formData = new FormData();
        formData.append('filepond[]', fileObject);

        try {
            const data = await ChatRepository.uploadVoice(formData);
            return data;
        }catch (e) {

        }
    }

    const sendVoiceMessage = async  (audioBlob) => {
       try{
           const response = await uploadVoice(audioBlob);
           serverSendMessageEmitter(socket,{
               to: to.value,
               file: response.data[0].key,
               message: response.data[0].name,
               media_type: 'audio/mpeg',
           },(response)=>{
               if(response.status === 'ok') emits('update-voice-message', response.data)
           });
       }catch (e) {
            console.log(e)
       }
    };




    const formattedTime = computed(() => {
        const minutes = Math.floor(timer.value / 60);
        const seconds = timer.value % 60;
        return `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
    });

    return {
        startRecording,
        stopRecording,
        formattedTime,
        isRecording,
    };
}
