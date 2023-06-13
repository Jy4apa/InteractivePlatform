import {STORAGE_KEYS} from "@/common/const/config";

export default {
    token: localStorage.getItem(STORAGE_KEYS.ACCESS) || "",
}
