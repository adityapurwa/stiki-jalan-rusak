import Axios from 'axios';
import Cookies from 'js-cookie';

export const API_URL = '34.74.151.24';

const headers = {
	'Content-Type': 'application/json',
};
if (Cookies.get('PHPSESSID') !== undefined) {
	headers['X-PHP-SESSID'] = Cookies.get('PHPSESSID');
}

const axe = Axios.create({
	baseURL: `https://${ API_URL }/v1/`,
	headers: headers,
});
axe.interceptors.request.use(conf => {
	if (Cookies.get('PHPSESSID') !== undefined) {
		conf.headers['X-PHP-SESSID'] = Cookies.get('PHPSESSID');
	}
	return conf;
});

export default axe;
