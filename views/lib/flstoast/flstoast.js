const FlsToast = ({ type, title, message, timer = 5000,  vibrate = [], playSound = null }) => {
    return new Promise(resolve => {
        const body = document.querySelector('body');
        const scripts = document.getElementsByTagName('script');
        let src = '';

        for (let script of scripts) {
            if (script.src.includes('flstoast.js')) {
                src = script.src.substring(0, script.src.lastIndexOf('/'));
            }
        }

        let templateContainer = document.querySelector('.toast-container');
        if (!templateContainer) {
            body.insertAdjacentHTML(
                'afterend',
                '<div class="toast-container"></div>',
            );
            templateContainer = document.querySelector('.toast-container');
        }

        const toastId = id();
        const templateContent = `
            <div class="toast-content ${type}-bg" id="${toastId}-toast-content">
                <div>
                    <div class="toast-frame">
                    <div class="toast-body">
                        <img class="toast-body-img" src="${src}/img/${type}.svg" />'
                        <div class="toast-body-content">
                        <span class="toast-title">${title}</span>
                        <span class="toast-message">${message}</span>
                        </div>
                        <div class="toast-close" id="${toastId}-toast-close">X</div>
                    </div>
                    </div>
                    <div class="toast-timer ${type}-timer"  style="animation: timer${timer}ms linear;>
                </div>
            </div>`;

        const toasts = document.querySelectorAll('.toast-content');

        if (toasts.length) {
            toasts[0].insertAdjacentHTML('beforebegin', templateContent);
        } else {
            templateContainer.innerHTML = templateContent;
        }

        const toastContent = document.getElementById(`${toastId}-toast-content`);
        if (vibrate.length > 0) {
            navigator.vibrate(vibrate);
        }

        if (playSound !== null) {
            let sound = new Audio(playSound);
            sound.play();
        }

        setTimeout(() => {
            toastContent.remove();
            resolve();
        }, timer);

        const toastClose = document.getElementById(`${toastId}-toast-close`);

        toastClose.addEventListener('click', () => {
            toastContent.remove();
            resolve();
        });
    });
};
  
const id = () => {
    return '_' + Math.random().toString(36).substr(2, 9);
};