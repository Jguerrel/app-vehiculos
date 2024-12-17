import { ref } from "vue";

export const filterRepairCategory = ref([]);

export const getAllRepairCategory = (repaircategories,form) => {
    const data = repaircategories.filter((repaircategory) => repaircategory.repair_category_id === form.repair_category_id);
    filterRepairCategory.value = data;
};
export const clearForm = (form) => {
    form.name = "";
    form.repair_category_id = null;
};

export const handleUpdate = (form,id) => {
    form.put(route("repairsubcategories.update",id), {
        onStart: () => console.log("start"),
        onFinish: () => console.log("finish"),
        onError: (error) => console.log(error),
        onSuccess: () => clearForm(form),
    });
};
