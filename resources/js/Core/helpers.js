export default {

    getHeadersData(component, info = {}) {
        let data = {
            title: '',
            description: ''
        };

        switch (component) {
            case 'Diaries/Show':
                data.title = info.diary.name;
                data.description = info.diary.description
                break;
            case 'Home/Dashboard/Index':
                data.title = 'dashboard';
                data.description = 'you can see your statistics and your last watched movies and tv series here'
                break;
            case 'Diaries/Index':
                data.title = 'manage diaries';
                data.description = 'you can create, delete and update your diaries here'
                break;
            case 'Search/Index':
                data.title = 'add movies or tv series';
                data.description = 'search for movies and tv series to add them to your diariese'
                break;
            case 'Settings/Index':
                data.title = 'settings';
                data.description = 'you can manage your settings here'
                break;
        }
        return data;

    },




}
