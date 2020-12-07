/**
 * localStorage wrapper, prefixes automatically.
 */
class Storage {
  prefix: string

  constructor(prefix = 'myEmptyPlugin') {
    this.prefix = prefix
  }

  get(key: string, defaultValue: any) {
    const data = localStorage.getItem(this.prefix + key)

    if (data !== null) {
      const value = data ? JSON.parse(data) : data

      return value
    } else {
      console.log(
        `No value found for ${key}, falling back to default`,
        defaultValue
      )

      return defaultValue
    }
  }

  set(key: string, value: any) {
    try {
      localStorage.setItem(this.prefix + key, JSON.stringify(value))

      return true
    } catch (e) {
      console.error(e, key, value)

      return false
    }
  }
}

const instance = new Storage()

export { Storage, instance }
