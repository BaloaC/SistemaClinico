export default function getAge(year, month, day) {
    const birth = new Date(year, month - 1, day),
        now = new Date(),
        diff = new Date(now.valueOf() - birth.valueOf());
    return Math.abs(diff.getFullYear() - 1970);
}