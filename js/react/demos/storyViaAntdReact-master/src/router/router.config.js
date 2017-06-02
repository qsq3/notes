import Main from '../components/main/Main';
import Search from '../components/main/search/Search';
import About from '../components/main/about/About';
import BookIntro from '../components/main/bookIntro/BookIntro';
import Read from '../components/main/read/Read';
import ChangeOrigin from '../components/main/changeOrigin/ChangeOrigin';
import ReadDetail from '../components/main/read/ReadDetail';
const routes = [
    {
        path: '/search',
        component: Search,
        exact: true,
    },
    {
        path: '/about',
        component: About,
        exact: true,
    },
    {
        path: '/bookIntro/:id',
        component: BookIntro,
        exact: true,
    },
    {
        path: '/read/:id',
        component: Read
    },{
        path: '/changeOrigin',
        component: ChangeOrigin,
        exact: true,
    },{
        path: '/readDetail/:id',
        component: ReadDetail,
        exact: true,
    }
    ,{
        component: Main
    }
];

export default routes;