const FlsConfirm = ({
    message,
    confirmText = 'Si',
    cancelText = 'No',
  }) => {
    return new Promise(resolve => {
        const existingConfirm = document.querySelector('.confirm-delete');
        if (existingConfirm)
            existingConfirm.remove();
  
        const body = document.querySelector('body');
        let btnTemplate = `
            <div class="btn-actions">
                <button class="btn-no">${cancelText}</button>
                <button class="btn-yes">${confirmText}</button>
            </div>`;
        const template = `
            <div class="confirm-delete">
                <p>${message}</p>
                ${btnTemplate}
            </div>`;
  
        body.insertAdjacentHTML('afterend', template);
        const confirmWrapper = document.querySelector('.confirm-delete');
        const confirmButton = document.querySelector('.btn-yes');
        const cancelButton = document.querySelector('.btn-no');
        
        confirmButton.addEventListener('click', () => {
            confirmWrapper.remove();
            resolve('confirm');
        });
  
        cancelButton.addEventListener('click', () => {
            confirmWrapper.remove();
            resolve();
        });
    });
};