import demo from "./Demo";
import global from '../utils/global';

const note = {

    async getFolders(isDemo, isAdmin = false) {

        let url = '';
        if (isAdmin) {
            url = '/cp/folders';
        } else {
            url = isDemo ? '/api/demo/folders' : '/api/folders';
        }


        const response = await axios.get(url);

        if (isDemo) {
            let folders = demo.getFolders();

            if (!folders) {
                demo.setFolders(response.data.data);
            }

            return demo.getFolders();
        }

        return response.data.data
    },

    async storeFolder(payload, isDemo, isAdmin) {
        if (isDemo) {
            let request = { ...payload,
                id: global.randomNumber(),
                notes: [],
                created_at: new Date() ,
                updated_at : new Date()
            };

            let folders =  demo.getFolders();
            folders.push(request);
            demo.setFolders(folders);

            return request;
        } else {
            const prefix = isAdmin ? 'cp' : 'api';
            const response = await axios.post(`/${prefix}/folders`, payload);

            return response.data.data
        }
    },

    async updateFolder(payload, id, isDemo, currentNote, isAdmin) {
        if (isDemo) {
            let folders =  demo.getFolders();
            let folder = folders.find(f => f.id === id);

            folder.name = payload.name;
            demo.setFolders(folders);

            return { note: this.singleNote(folders, id, currentNote.id) };

        } else {
            let prefix = isAdmin ? 'cp' : 'api';
            const response = await axios.put(`/${prefix}/folders/${id}`, payload);

            return response.data;
        }
    },

    async deleteFolder(id, isDemo, isAdmin) {
        if (isDemo) {
            let folders =  demo.getFolders();
            folders.splice(folders.findIndex(f => f.id === id), 1);
            demo.setFolders(folders);

            return 'Folder deleted successfully.';

        } else {
            let prefix = isAdmin ? 'cp' : 'api';
            const response = await axios.delete(`/${prefix}/folders/${id}`);

            return response.data.message;
        }
    },

    async storeNote(payload, isDemo, isDefault, isAdmin) {
        if (isDemo) {
            let folders =  demo.getFolders();
            let id = global.uuid();
            let public_url = global.url(`demo/${id}`);
            let note = { ...payload, id, public_url };
            let folder = folders.find(f => f.id === payload.folder_id);

            if (folder) {
                folder.notes.push(note);
            } else {
                if (isDefault) {
                    let folder = {
                        id: payload.folder_id,
                        name: 'Default',
                        notes:[note],
                        created_at: new Date(),
                        updated_at : new Date()
                    };

                    folders.push(folder);
                }
            }

            demo.setFolders(folders);

            return note;
        } else {
            let prefix = isAdmin ? 'cp' : 'api';
            const response = await axios.post(`/${prefix}/cornell-notes`, payload);

            if (response.status == 203) {
                return false;
            }

            return response.data.data;
        }
    },

    async updateNote(currentNote, isDemo, isAdmin) {
        if (isDemo) {
            let folders =  demo.getFolders();
            let folder = folders.find(f => f.id == currentNote.folder_id);
            let note = folder.notes.find(n => n.id == currentNote.id);

            note.title = currentNote.title;

            demo.setFolders(folders);

            return this.singleNote(folders, currentNote.folder_id, currentNote.id);
        } else {
            let prefix = isAdmin ? 'cp' : 'api';
            const response = await axios.put(`/${prefix}/cornell-notes/${currentNote.id}`, { title : currentNote.title });

            return response.data.data;
        }
    },

    async deleteNote(currentNote, isDemo, isAdmin) {
        if (isDemo) {
            let folders =  demo.getFolders();
            let folder = folders.find(f => f.id == currentNote.folder_id);
            let index = folder.notes.findIndex(n => n.id == currentNote.id);

            folder.notes.splice(index, 1);

            demo.setFolders(folders);

            return 'Note deleted successfully.';
        } else {
            let prefix = isAdmin ? 'cp' : 'api';
            const response = await axios.delete(`/${prefix}/cornell-notes/${currentNote.id}`);

            return response.data.message;
        }
    },

    async moveNote(folders, payload, id, isDemo) {
        if (isDemo) {
            demo.setFolders(folders);

            return this.singleNote(folders, payload.folder_id, id);
        } else {
            const response = await axios.put(`/api/cornell-notes/${id}/move`, payload);

            return response.data.data;
        }
    },

    singleNote(folders, folder_id, noteId) {
        let folder = folders.find(f => f.id == folder_id);
        let note = folder.notes.find(n => n.id == noteId);

        return { ...note, folder : folder};
    },

    removeFolder() {
        demo.removeFolder();
    }
}

export default note;
