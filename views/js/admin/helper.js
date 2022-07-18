class Helper {
    static showLoading() {
        document.getElementById('fl-loading').classList.add('fl-show-loading');
        document.getElementById('fl-loading').classList.remove('hidden');
    }
    static hideLoading() {
        document.getElementById('fl-loading').classList.add('hidden');
        document.getElementById('fl-loading').classList.remove('fl-show-loading');
    }

}