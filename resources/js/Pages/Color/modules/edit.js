
export const clearForm = (form) => {
    form.reset("name", "");
};

export const handleUpdate = (form,id) => {
    form.put(route("utils.colors.update",id), {
        onStart: () => console.log("start"),
        onFinish: () => console.log("finish"),
        onError: (error) => console.log(error),
        onSuccess: () => clearForm(),
    });
};
