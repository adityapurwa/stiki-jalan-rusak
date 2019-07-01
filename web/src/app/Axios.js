import Axios from 'axios';
import Cookies from 'js-cookie';

const headers = {
	'Content-Type': 'application/json',
};
if (Cookies.get('PHPSESSID') !== undefined) {
	headers['X-PHP-SESSID'] = Cookies.get('PHPSESSID');
}

const axe = Axios.create({
	baseURL: 'http://api.laporjalan.lrg/v1/',
	headers: headers
});

export default axe;
