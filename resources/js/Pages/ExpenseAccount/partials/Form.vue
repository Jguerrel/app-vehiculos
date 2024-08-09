<script setup>
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";

defineProps(["form"]);
defineEmits(["update:accountNumber", "update:accountName"]);
</script>
<template>
    <section>
        <div class="w-full">
            <div class="py-5 flex flex-col gap-5">
                <div>
                    <InputLabel
                        for="account_number"
                        value="Nº de cuenta"
                        class="font-bold text-lg"
                    />
                    <TextInput
                        id="account_number"
                        type="text"
                        class="mt-1 block w-full border-gray-200 border"
                        :value="form.account_number"
                        @input="
                            $emit('update:accountNumber', $event.target.value)
                        "
                        required
                    />
                    <InputError
                        class="mt-2"
                        :message="form.errors.account_number"
                    />
                </div>
            </div>
        </div>
        <div class="w-full">
            <div class="py-5 flex flex-col gap-5">
                <div>
                    <InputLabel
                        for="account_name"
                        value="Nombre de la cuenta"
                        class="font-bold text-lg"
                    />
                    <TextInput
                        id="account_name"
                        type="text"
                        class="mt-1 block w-full border-gray-200 border"
                        :value="form.account_name"
                        @input="
                            $emit('update:accountName', $event.target.value)
                        "
                        required
                    />
                    <InputError
                        class="mt-2"
                        :message="form.errors.account_name"
                    />
                </div>
            </div>
        </div>
    </section>
</template>
