import { formatDistance, format } from 'date-fns';

const global = {
    url(path) {
        return `${DN.baseUrl}/${path}`;
    },

    timeAgo(date) {
        return formatDistance(new Date(date), new Date(), { addSuffix: true })
    },

    formatDate(timestamp, dateFormat) {
        return format(new Date(timestamp * 1000), dateFormat);
    },

    uuid() {
        let date = new Date().getTime();

        const uuid = 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
            const random = (date + Math.random() *16) %16 | 0;
            date = Math.floor(date/16);

            return (c === 'x' ? random :(random&0x3|0x8)).toString(16);
        });

        return uuid;
    },

    randomNumber() {
        return Math.floor(1000 + Math.random() * 9000);
    },

    cursor(el) {
        let atStart = false, atEnd = false;
        let selectionRange, testRange;

        if (window.getSelection) {
            let selection = window.getSelection();

            if (selection.rangeCount) {
                selectionRange = selection.getRangeAt(0);
                testRange = selectionRange.cloneRange();

                testRange.selectNodeContents(el);
                testRange.setEnd(selectionRange.startContainer, selectionRange.startOffset);
                atStart = (testRange.toString() === '');

                testRange.selectNodeContents(el);
                testRange.setStart(selectionRange.endContainer, selectionRange.endOffset);
                atEnd = (testRange.toString() === '');
            }
        } else if (document.selection && document.selection.type !== 'Control') {
            selectionRange = document.selection.createRange();
            testRange = selectionRange.duplicate();

            testRange.moveToElementText(el);
            testRange.setEndPoint("EndToStart", selectionRange);
            atStart = (testRange.text === '');

            testRange.moveToElementText(el);
            testRange.setEndPoint("StartToEnd", selectionRange);
            atEnd = (testRange.text === '');
        }

        return { atStart, atEnd };
    },

    editorHasContent(id) {
        const editor = document.getElementById(id) ;

        return editor.textContent ||
            editor.getElementsByTagName('figure').length > 0 ||
            editor.getElementsByTagName('img').length > 0 ||
            editor.getElementsByTagName('oembed').length > 0;
    }
}

export default global;
