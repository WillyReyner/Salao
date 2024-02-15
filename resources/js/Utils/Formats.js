import moment from 'moment-timezone';

export function formatDate(date) {
    const localDate = moment.utc(date).tz('America/Sao_Paulo');
    return localDate.format('DD/MM/YYYY HH:mm:ss');
}
