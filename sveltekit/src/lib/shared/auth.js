/**
 * Kontroll om man är inloggad eller ej.
 *
 * @returns "auth": true/false,"userdata": {"uid": ..., "firstname": ..., "surname": ...}
 */
export async function auth() {
  let result = { auth: false, userData: null };

  try {
    const response = await fetch("/api/auth.php");
    const fetchresponse = await response.json();
    result["auth"] = fetchresponse["success"];
    if (fetchresponse["success"]) {
      result.userData = {
        username: fetchresponse["username"],
        uid: fetchresponse["uid"],
        email: fetchresponse["email"],
      };
    }
  } catch (e) {}

  return result;
}
