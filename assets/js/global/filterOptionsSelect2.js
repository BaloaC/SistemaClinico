export default function filterOptionsSelect2({ options, optionId, selectedValues }) {
    return options.filter(option => !selectedValues.includes(option[optionId].toString()));
}