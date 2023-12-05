export default function select2DefaultValue() {
    const selects2 = document.querySelectorAll(".select2-hidden-accessible");

    if (selects2?.length > 0) {
        for (const select2 of selects2) {
            $(`#${select2.id}`).val([]).trigger('change');
        }
    }
}