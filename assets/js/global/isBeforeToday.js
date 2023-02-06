export default function isBeforeToday(date) {
    const today = new Date();

    today.setHours(0, 0, 0, 0);

    return date < today;
}