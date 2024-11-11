import axios from 'axios';

export const getLogData = async (period) => {
    const response = await axios.get(`/logs/${period}`);
    return response.data;
};
