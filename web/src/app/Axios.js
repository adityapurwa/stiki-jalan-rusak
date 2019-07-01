import Axios from 'axios';
import Cookies from 'js-cookie';

export const API_URL = 'localhost:1235';

const headers = {
	'Content-Type': 'application/json',
};
if (Cookies.get('PHPSESSID') !== undefined) {
	headers['X-PHP-SESSID'] = Cookies.get('PHPSESSID');
}

const axe = Axios.create({
	baseURL: `http://${ API_URL }/v1/`,
	headers: headers
});

export default axe;
