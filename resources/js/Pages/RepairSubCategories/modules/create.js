import { useForm } from "@inertiajs/inertia-vue3";
import { ref } from "vue";

export const filterRepairCategory = ref([]);
export const form = useForm({
    name: "",
    repair_category_id: "",
});

export const getAllRepairCategory = (repaircategories) => {
    const data = repaircategories.filter((repaircategory) => repaircategories.repair_category_id === form.repair_category_id);
    filterRepairCategory.value = data;
};

export const clearForm = () => {
    form.reset("name", "");
    form.reset("repair_category_id", "");
};


export const handleSave = () => {
    form.post(route("repairsubcategories.store"), {
        onStart: () => console.log("start"),
        onFinish: () => console.log("finish"),
        onError: (error) => console.log(error),
        onSuccess: () => clearForm(),
    });
};
