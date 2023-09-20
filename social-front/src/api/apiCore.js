import axios from 'axios';
const api  = axios.create({
  baseURL: 'http://127.0.0.1:8000/api',
});

// content type
api.defaults.headers.post['Content-Type'] = 'application/json';

api.interceptors.response.use(
  (response) => {
    return response;
  },
  async (err) => {
    const originalConfig = err.config;

    if (err.response) {
      // Access Token was expired
      if (err.response.status === 401 && !originalConfig._retry) {
        originalConfig._retry = true;

        try {
          return api(originalConfig);
        } catch (_error) {
          if (_error.response && _error.response.data) {
            return Promise.reject(_error.response.data);
          }

          return Promise.reject(_error);
        }
      }

      if (err.response.status === 403 && err.response.data) {
        return Promise.reject(err.response.data);
      }
    }

    return Promise.reject(err);
  }
);

/**
 * Sets the default authorization
 * @param {*} token
 */
const setAuthorization = (token) => {
  api.defaults.headers.common['Authorization'] = 'Bearer ' + token;
};

// class APIClient {
  
// }

/**
   * Fetches data from given url
   */
const getData = (url, params={}) => {
  return api.get(url, params);
};

/**
 * post given data to url
 */
const createData = (url, data = {}) => {
  return api.post(url, data);
};

/**
 * Updates data
 */
const updateData = (url, data = {}) => {
  return api.put(url, data);
};

/**
 * Delete
 */
const deleteData = (url, config = {}) => {
  return api.delete(url, { ...config });
};

/*
 file upload update method
 */
const updateWithFile = (url, data) => {
  const formData = new FormData();
  for (const k in data) {
    formData.append(k, data[k]);
  }
  const config = {
    headers: {
      ...api.defaults.headers,
      'content-type': 'multipart/form-data',
    },
  };
  return api.put(url, formData);
};

/*
 file upload post method
 */
const createWithFile = (url, data) => {
  const formData = new FormData();
  for (const k in data) {
    formData.append(k, data[k]);
  }
  const config = {
    headers: {
      ...api.defaults.headers,
      'content-type': 'multipart/form-data',
    },
  };
  return api.post(url, formData);
};

const setLoggeedInUser = ()=> {
  localStorage.setItem("authUser", JSON.stringify(1));
};

const getLoggedinUser = () => {
  const user = localStorage.getItem('authUser');
  if (!user) {
    return null;
  } else {
    return JSON.parse(user);
  }
};

export { setAuthorization, getLoggedinUser, setLoggeedInUser, getData, createData, updateData, deleteData, updateWithFile, createWithFile};
