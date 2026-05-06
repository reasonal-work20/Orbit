# Edit text file to be ready for sql data running.
path = "default-data/location-l3.txt"
data = ""
with open(path, "r") as file:
    for line in file:
        line = line.strip("\n")
        print(line)
        capacity = input("Capacity: ")
        access = input("Access\n1. Open\n2. Restricted: ")

        if not capacity or not access:
            continue

        if access == "1":
            data = data + f"{line},{capacity},Open\n"
        elif access == "2":
            data = data + f"{line},{capacity},Restricted\n"

with open(path, "w") as file:
    file.write(data)